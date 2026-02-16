<?php

namespace app\models;

use Flight;
use PDO;

class BngrcModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer toutes les villes
    public function getVilles() {
        return $this->db->query("SELECT * FROM BNGRC_villes")->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer la liste des produits/besoins existants en base (distinct)
    public function getProducts() {
        $sql = "SELECT DISTINCT nom FROM BNGRC_besoins UNION SELECT DISTINCT nom FROM BNGRC_dons ORDER BY nom";
        $st = $this->db->query($sql);
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        // Retourner un tableau simple de noms
        return array_map(function($r){ return $r['nom']; }, $rows);
    }

    // Insérer un besoin
    public function saveBesoin($nom, $quantite, $pu, $id_ville) {
        // Si un besoin du même nom existe déjà pour la même ville, on fusionne (somme des quantités)
        try {
            $this->db->beginTransaction();

            // Note: BNGRC_besoins table does not store 'quantite_attribuee' (attributions are in BNGRC_dispatch)
            $st = $this->db->prepare("SELECT id, quantite, prix_unitaire FROM BNGRC_besoins WHERE nom = ? AND id_ville = ? LIMIT 1");
            $st->execute([$nom, $id_ville]);
            $existing = $st->fetch(PDO::FETCH_ASSOC);

            if ($existing) {
                $existingQty = (int)$existing['quantite'];
                $existingPu = (float)$existing['prix_unitaire'];

                $newQty = $existingQty + (int)$quantite;
                // recompute prix_unitaire as weighted average by quantité
                $totalValue = ($existingPu * $existingQty) + ((float)$pu * (int)$quantite);
                $newPu = $newQty > 0 ? ($totalValue / $newQty) : $pu;
                // Update only quantity and unit price; attributions are managed in dispatch table
                $upd = $this->db->prepare("UPDATE BNGRC_besoins SET quantite = ?, prix_unitaire = ? WHERE id = ?");
                $ok = $upd->execute([$newQty, $newPu, $existing['id']]);
                $this->db->commit();
                return $ok;
            }

            $sql = "INSERT INTO BNGRC_besoins (nom, quantite, prix_unitaire, id_ville) VALUES (?, ?, ?, ?)";
            $res = $this->db->prepare($sql)->execute([$nom, $quantite, $pu, $id_ville]);
            $this->db->commit();
            return $res;
        } catch (\Throwable $e) {
            try { $this->db->rollBack(); } catch (\Throwable $_) {}
            throw $e;
        }
    }

    // Insérer un don
    public function saveDon($nom, $quantite, $date) {
        $sql = "INSERT INTO BNGRC_dons (nom, quantite, date_don) VALUES (?, ?, ?)";
        return $this->db->prepare($sql)->execute([$nom, $quantite, $date]);
    }
}