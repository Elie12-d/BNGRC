<?php

namespace app\controllers;

use app\models\BesoinsModel;
use app\models\VillesModel;
use app\models\DonsModel;
use app\models\DispatchModel;
use flight\Engine;
use Flight;

class DispatchController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Show the purchase/dispatch form (form_achat)
     * Prepares:
     *  - $villes : list of villes
     *  - $besoins : besoins with computed 'attribue' and 'reste'
     *  - $available_money : total of donations named 'Argent'
     */
    public function showForm()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        $villesModel = new VillesModel();
        $villes = $villesModel->getAll();

        $besoinsModel = new BesoinsModel();
        $besoins = $besoinsModel->getAll();

        $dispatchModel = new DispatchModel();
        $dispatchs = $dispatchModel->getAll();

        // compute attribue and reste per besoin
        foreach ($besoins as &$besoin) {
            $besoin['attribue'] = 0;
            foreach ($dispatchs as $d) {
                if ($d['id_besoin'] == $besoin['id'] && in_array($d['status'], ['complete', 'partiel', 'en_cours'])) {
                    $besoin['attribue'] += $d['quantite_attribuee'];
                }
            }
            $besoin['reste'] = max(0, ($besoin['quantite'] ?? 0) - $besoin['attribue']);
        }
        unset($besoin);

        // compute available monetary donations (dons with name 'Argent')
        $donsModel = new DonsModel();
        // Use model helper to compute monetary donations total directly from DB
        $available_money = $donsModel->getTotalMoney();

        // For the purchase form we pass all besoins (with computed reste).
        // The view will filter by selected city client-side for UX.
        // read and clear flash messages from session
        $flash = [];
        if (isset($_SESSION['flash_success'])) { $flash['success'] = $_SESSION['flash_success']; unset($_SESSION['flash_success']); }
        if (isset($_SESSION['flash_error']))   { $flash['error'] = $_SESSION['flash_error']; unset($_SESSION['flash_error']); }

        $this->app->render('form_achat', [
            'villes' => $villes,
            'besoins' => $besoins,
            'available_money' => $available_money,
            'flash' => $flash,
        ]);
    }

    /**
     * Handle POST /achat/validate
     * Validates funds and records dispatch entries.
     */
    public function validate()
    {
        $data = Flight::request()->data;
        $id_ville = isset($data->id_ville) ? (int)$data->id_ville : null;
        $besoin_ids = isset($data->besoin_ids) ? (array)$data->besoin_ids : [];
        $fee_percent = isset($data->fee_percent) ? (float)$data->fee_percent : 0.0;

        // log raw posted payload for debugging
        try {
            $raw = [];
            foreach ($data as $k => $v) { $raw[$k] = $v; }
            error_log('[Dispatch] Raw POST data: ' . json_encode($raw));
        } catch (\Throwable $e) {
            error_log('[Dispatch][WARN] could not stringify POST data: ' . $e->getMessage());
        }

        // guard: if no besoins selected, don't proceed
        if (empty($besoin_ids)) {
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['flash_error'] = 'Aucune ligne sélectionnée — veuillez cocher au moins un besoin avant de valider.';
            error_log('[Dispatch] No besoin_ids posted; aborting validate.');
            Flight::redirect('/dispatch');
            return;
        }

        $besoinsModel = new BesoinsModel();
        $donsModel = new \app\models\DonsModel();
        $dispatchModel = new DispatchModel();

        // Compute total needed (sum quantite * prix_unitaire for selected besoins)
        $totalNeeded = 0;
        $selectedBesoins = [];
        foreach ($besoin_ids as $bid) {
            $b = $besoinsModel->getById((int)$bid);
            if (!$b) continue;
            // compute reste using existing dispatch totals
            $already = $dispatchModel->getTotalByBesoin($b['id']);
            $reste = max(0, ($b['quantite'] ?? 0) - $already);
            if ($reste <= 0) continue;
            $amount = (float)($b['prix_unitaire'] ?? 0) * (float)$reste;
            $totalNeeded += $amount;
            $selectedBesoins[] = ['besoin' => $b, 'reste' => $reste, 'amount' => $amount];
        }

        $feeAmount = round($totalNeeded * ($fee_percent/100));
        $net = $totalNeeded + $feeAmount;

        // compute available money
        $available = 0;
        $allDons = $donsModel->getAll();
        foreach ($allDons as $don) {
            if (isset($don['nom']) && strtolower(trim($don['nom'])) === 'argent') {
                $available += (float)($don['quantite'] ?? 0);
            }
        }

        if ($available < $net) {
            // insufficient funds: set flash and redirect back
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['flash_error'] = 'Fonds insuffisants pour effectuer cet achat.';
            Flight::redirect('/dispatch');
            return;
        }

        // Begin DB transaction so updates + dispatch inserts are atomic
        $pdo = \Flight::db();
        // Log total argent before transaction for debugging
        try {
            $beforeTotal = $donsModel->getTotalMoney();
            error_log("[Dispatch] total_argent BEFORE transaction = {$beforeTotal}");
        } catch (\Throwable $e) {
            error_log("[Dispatch][WARN] could not read total before transaction: " . $e->getMessage());
        }
        try {
            $pdo->beginTransaction();

            // For each selected besoin, allocate the required MONEY (prix_unitaire * reste)
            // Deduct funds from 'Argent' donations FIFO until the money_needed is covered.
            foreach ($selectedBesoins as $sb) {
                $besoin = $sb['besoin'];
                $need_items = (int)$sb['reste'];
                if ($need_items <= 0) continue;

                $prix_unitaire = (float)($besoin['prix_unitaire'] ?? 0);
                $money_needed = round($sb['amount']); // money required to buy the remaining items

                $firstDonId = null;

                // iterate through donations to cover money_needed
                foreach ($allDons as $idx => $don) {
                    if ($money_needed <= 0) break;
                    if (strtolower(trim($don['nom'])) !== 'argent') continue;
                    $donId = $don['id'];
                    $availableAmount = (float)($don['quantite'] ?? 0);
                    if ($availableAmount <= 0) continue;

                    $take = min($availableAmount, $money_needed);

                    // update DB donation quantity by subtracting the money taken
                    $newAmount = $availableAmount - $take;
                    error_log("[Dispatch] Updating don id={$donId} before={$availableAmount} after={$newAmount}");
                    $ok = $donsModel->update($donId, $don['nom'], $newAmount);
                    if ($ok === false) {
                        // log DB error state from PDO inside model (best effort)
                        error_log("[Dispatch][ERROR] update returned false for don id={$donId}");
                    }
                    // read back the current DB value to confirm
                    $afterRow = $donsModel->getById($donId);
                    $afterQuant = $afterRow['quantite'] ?? '(missing)';
                    error_log("[Dispatch] After update read don id={$donId} quantite={$afterQuant}");
                    $allDons[$idx]['quantite'] = $afterQuant;

                    // remember first donation id used to reference in the dispatch record
                    if ($firstDonId === null) $firstDonId = $donId;

                    $money_needed -= $take;
                }

                if ($money_needed > 0) {
                    // Shouldn't happen because we checked available >= net earlier, but guard
                    throw new \RuntimeException('Impossible d\'allouer la totalité (argent) pour le besoin ID ' . $besoin['id']);
                }

                // Create a single dispatch record for this besoin: quantite_attribuee uses item count
                if ($firstDonId === null) {
                    throw new \RuntimeException('Aucun don en argent disponible pour créer le dispatch (unexpected)');
                }
                $status = 'complete';
                $dispatchModel->create($firstDonId, $besoin['id'], $need_items, $status);
            }

            // Finally, deduct the feeAmount from remaining 'Argent' donations (FIFO)
            $feeRemaining = $feeAmount;
            if ($feeRemaining > 0) {
                foreach ($allDons as $idx => $don) {
                    if ($feeRemaining <= 0) break;
                    if (strtolower(trim($don['nom'])) !== 'argent') continue;
                    $donId = $don['id'];
                    $availableAmount = (float)($don['quantite'] ?? 0);
                    if ($availableAmount <= 0) continue;

                    $take = min($availableAmount, $feeRemaining);
                    $newAmount = $availableAmount - $take;
                    error_log("[Dispatch] Deducting fee from don id={$donId} before={$availableAmount} after={$newAmount}");
                    $ok = $donsModel->update($donId, $don['nom'], $newAmount);
                    if ($ok === false) {
                        error_log("[Dispatch][ERROR] fee update returned false for don id={$donId}");
                    }
                    $afterRow = $donsModel->getById($donId);
                    $afterQuant = $afterRow['quantite'] ?? '(missing)';
                    error_log("[Dispatch] After fee update read don id={$donId} quantite={$afterQuant}");
                    $allDons[$idx]['quantite'] = $afterQuant;

                    $feeRemaining -= $take;
                }

                if ($feeRemaining > 0) {
                    throw new \RuntimeException('Impossible de prélever totalement les frais depuis les dons en argent');
                }
            }

            $pdo->commit();
            error_log("[Dispatch] commit successful. Total needed={$totalNeeded}, fee={$feeAmount}, net={$net}");
            // log total argent after commit to confirm DB changes
            try {
                $afterTotal = $donsModel->getTotalMoney();
                error_log("[Dispatch] total_argent AFTER commit = {$afterTotal}");
            } catch (\Throwable $e) {
                error_log("[Dispatch][WARN] could not read total after commit: " . $e->getMessage());
            }
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();
            $_SESSION['flash_success'] = 'Achat enregistré avec succès. Solde mis à jour.';
        } catch (\Throwable $e) {
            $pdo->rollBack();
            // log error and redirect back
            error_log('Dispatch validate error: ' . $e->getMessage());
            Flight::redirect('/dispatch');
            return;
        }

        // redirect back to the dispatch form so the updated money balance is visible
        Flight::redirect('/dispatch');
    }
}
