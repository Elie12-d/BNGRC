<?php

namespace app\models;

use Flight;
use PDO;

class BesoinsModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Flight::db();
    }

    public function create($nom, $quantite, $prix_unitaire, $id_ville)
    {
        $st = $this->pdo->prepare("
            INSERT INTO BNGRC_besoins(nom, quantite, prix_unitaire, id_ville)
            VALUES(?, ?, ?, ?)
        ");

        $st->execute([
            (string)$nom,
            (int)$quantite,
            (float)$prix_unitaire,
            (int)$id_ville
        ]);

        return $this->pdo->lastInsertId();
    }

    public function getAll()
    {
        $st = $this->pdo->query("
            SELECT b.*, v.nom as ville_nom
            FROM BNGRC_besoins b
            LEFT JOIN BNGRC_villes v ON b.id_ville = v.id
        ");

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $st = $this->pdo->prepare("
            SELECT * FROM BNGRC_besoins WHERE id = ?
        ");

        $st->execute([(int)$id]);

        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nom, $quantite, $prix_unitaire, $id_ville)
    {
        $st = $this->pdo->prepare("
            UPDATE BNGRC_besoins
            SET nom = ?, quantite = ?, prix_unitaire = ?, id_ville = ?
            WHERE id = ?
        ");

        return $st->execute([
            (string)$nom,
            (int)$quantite,
            (float)$prix_unitaire,
            (int)$id_ville,
            (int)$id
        ]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("
            DELETE FROM BNGRC_besoins WHERE id = ?
        ");

        return $st->execute([(int)$id]);
    }
    public function getAllOrderByDate()
    {
        // Determine which date column exists in the current database/schema.
        // Some environments use `date_creation`, others `date_saisie`.
        try {
            $colSt = $this->pdo->prepare(
                "SELECT COLUMN_NAME FROM information_schema.COLUMNS
                 WHERE TABLE_SCHEMA = DATABASE()
                   AND TABLE_NAME = 'BNGRC_besoins'
                   AND COLUMN_NAME IN ('date_creation','date_saisie')
                 ORDER BY FIELD(COLUMN_NAME,'date_creation','date_saisie')
                 LIMIT 1"
            );
            $colSt->execute();
            $dateCol = $colSt->fetchColumn();
        } catch (\Exception $e) {
            // If something goes wrong querying information_schema, fall back
            // to not using an ORDER BY so the query doesn't fail.
            $dateCol = false;
        }

        $order = $dateCol ? "ORDER BY `" . $dateCol . "` ASC" : "";

        $sql = "SELECT * FROM BNGRC_besoins " . $order;
        $st = $this->pdo->query($sql);

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTotalBesoins()
    {
        $st = $this->pdo->query("
        SELECT SUM(quantite * prix_unitaire) as total 
        FROM BNGRC_besoins
    ");
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
    public function reset()
    {
        $st = $this->pdo->prepare("DELETE FROM BNGRC_besoins");
        $st->execute();
        $st = $this->pdo->prepare("ALTER TABLE BNGRC_besoins AUTO_INCREMENT = 1");
        $st->execute();
    }
    public function getAllOrderByMinQuantity()
    {
        $st = $this->pdo->query("
            SELECT * FROM BNGRC_besoins 
            ORDER BY quantite ASC
        ");

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllNameBesoin()
    {
        $st = $this->pdo->query("SELECT nom, quantite FROM BNGRC_besoins GROUP BY nom");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllSameBesoin()
    {
        $allNoms = $this->getAllNameBesoin();
        $result = [];
        foreach ($allNoms as $nom) {
            $st = $this->pdo->prepare("SELECT * FROM BNGRC_besoins WHERE nom = ?");
            $st->execute([$nom['nom']]);
            $besoins = $st->fetchAll(PDO::FETCH_ASSOC);
            if (count($besoins) > 1) {
                $result[] = [
                    'nom' => $nom['nom'],
                    'quantite' => $nom['quantite'],
                    'id' => $besoins[0]['id']
                ];
            } else {
                $result[] = [
                    'nom' => $nom['nom'],
                    'quantite' => $nom['quantite'],
                    'id' => $besoins[0]['id']
                ];
            }
        }
        return $result;
    }
    public function getTotalQuantiteByName($nom)
    {
        $st = $this->pdo->prepare("SELECT SUM(quantite) as total FROM BNGRC_besoins WHERE nom = ?");
        $st->execute([$nom]);
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
