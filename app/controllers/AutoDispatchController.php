<?php

namespace app\controllers;

use app\models\BesoinsModel;
use app\models\RegionsModel;
use app\models\VillesModel;
use app\models\DonsModel;
use app\models\DispatchModel;
//session_start();
use flight\Engine;

class AutoDispatchController
{

    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }
    public function autoDispatch()
    {
        $besoinsModel = new BesoinsModel();
        $donsModel = new DonsModel();
        $dispatchModel = new DispatchModel();

        $besoins = $besoinsModel->getAllOrderByDate();  // ASC (plus ancien d'abord)
        $dons = $donsModel->getAllOrderByDate();

        foreach ($dons as &$don) {
            $quantiteDonRestante = $don['quantite'];
            $totalDistribue = 0;

            foreach ($besoins as &$besoin) {
                if ($quantiteDonRestante <= 0) break;
                // verifie si le besoin est deja satisfait
                $dejaAttribue = $dispatchModel->getTotalByBesoin($besoin['id']);
                $resteBesoin = $besoin['quantite'] - $dejaAttribue;

                if ($resteBesoin <= 0) continue; // besoin déjà satisfait

                // verification de la correspondance
                if (!$this->correspondType($don['nom'], $besoin['nom'])) {
                    continue;
                }

                // calculer la quantité à attribuer
                $aAttribuer = min($quantiteDonRestante, $resteBesoin);

                // creer le dispatch
                $dispatchModel->create(
                    $don['id'],
                    $besoin['id'],
                    $aAttribuer,
                    $this->determinerStatus($resteBesoin, $aAttribuer)
                );
                $quantiteDonRestante -= $aAttribuer;
                $totalDistribue += $aAttribuer;
            }
            if ($totalDistribue > 0) {
                $nouvelleQuantite = $don['quantite'] - $totalDistribue;
                $donsModel->updateQuantite($don['id'], $nouvelleQuantite);
            }
        }
        $this->app->redirect('/Dashboard');
    }
    private function correspondType($nomDon, $nomBesoin)
    {
        $typeDon = strtolower(trim($nomDon));
        $typeBesoin = strtolower(trim($nomBesoin));

        if ($typeDon == $typeBesoin) {
            return true;
        }
        return false;
    }
    private function determinerStatus($resteAvant, $attribue)
    {
        if ($attribue >= $resteAvant) {
            return 'complete';
        } else {
            return 'partiel';
        }
    }
}
