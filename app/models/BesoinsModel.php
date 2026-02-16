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
        $st = $this->pdo->query("
            SELECT * FROM BNGRC_besoins ORDER BY date_creation ASC
        ");

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
