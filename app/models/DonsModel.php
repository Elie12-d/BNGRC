<?php

namespace app\models;

use Flight;
use PDO;

class DonsModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Flight::db();
    }

    public function create($nom, $quantite)
    {
        $st = $this->pdo->prepare("
            INSERT INTO BNGRC_dons(nom, quantite)
            VALUES(?, ?)
        ");

        $st->execute([
            (string)$nom,
            (int)$quantite
        ]);

        return $this->pdo->lastInsertId();
    }

    public function getAll()
    {
        $st = $this->pdo->query("SELECT * FROM BNGRC_dons");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $st = $this->pdo->prepare("
            SELECT * FROM BNGRC_dons WHERE id = ?
        ");

        $st->execute([(int)$id]);

        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nom, $quantite)
    {
        $st = $this->pdo->prepare("
            UPDATE BNGRC_dons SET nom = ?, quantite = ? WHERE id = ?
        ");

        return $st->execute([
            (string)$nom,
            (int)$quantite,
            (int)$id
        ]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("
            DELETE FROM BNGRC_dons WHERE id = ?
        ");

        return $st->execute([(int)$id]);
    }
    public function getAllOrderByDate()
    {
        $st = $this->pdo->query("
            SELECT * FROM BNGRC_dons ORDER BY date_creation ASC
        ");

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
