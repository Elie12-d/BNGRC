<?php

namespace app\models;

use Flight;
use PDO;

class VillesModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Flight::db();
    }

    public function create($nom, $id_region)
    {
        $st = $this->pdo->prepare("
            INSERT INTO BNGRC_villes(nom, id_region)
            VALUES(?, ?)
        ");

        $st->execute([
            (string)$nom,
            (int)$id_region
        ]);

        return $this->pdo->lastInsertId();
    }

    public function getAll()
    {
        $st = $this->pdo->query("
            SELECT * FROM BNGRC_villes
        ");

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $st = $this->pdo->prepare("
            SELECT * FROM BNGRC_villes WHERE id = ?
        ");

        $st->execute([(int)$id]);

        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nom, $id_region)
    {
        $st = $this->pdo->prepare("
            UPDATE BNGRC_villes
            SET nom = ?, id_region = ?
            WHERE id = ?
        ");

        return $st->execute([
            (string)$nom,
            (int)$id_region,
            (int)$id
        ]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("
            DELETE FROM BNGRC_villes WHERE id = ?
        ");

        return $st->execute([(int)$id]);
    }
    public function reset() {
        $sql = "DELETE FROM BNGRC_villes";
        $this->pdo->exec($sql);
        $sql = "ALTER TABLE BNGRC_villes AUTO_INCREMENT = 1";
        $this->pdo->exec($sql);
    }
}
