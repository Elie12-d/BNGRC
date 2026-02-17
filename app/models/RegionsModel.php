<?php

namespace app\models;

use Flight;
use PDO;

class RegionsModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Flight::db();
    }

    public function create($nom)
    {
        $st = $this->pdo->prepare("
            INSERT INTO BNGRC_regions(nom)
            VALUES(?)
        ");

        $st->execute([
            (string)$nom
        ]);

        return $this->pdo->lastInsertId();
    }

    public function getAll()
    {
        $st = $this->pdo->query("SELECT * FROM BNGRC_regions");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $st = $this->pdo->prepare("
            SELECT * FROM BNGRC_regions WHERE id = ?
        ");

        $st->execute([(int)$id]);

        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nom)
    {
        $st = $this->pdo->prepare("
            UPDATE BNGRC_regions SET nom = ? WHERE id = ?
        ");

        return $st->execute([
            (string)$nom,
            (int)$id
        ]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("
            DELETE FROM BNGRC_regions WHERE id = ?
        ");

        return $st->execute([(int)$id]);
    }
    public function reset() {
        $sql = "DELETE FROM BNGRC_regions";
        $this->pdo->exec($sql);
        $sql = "ALTER TABLE BNGRC_regions AUTO_INCREMENT = 1";
        $this->pdo->exec($sql);
    }
}
