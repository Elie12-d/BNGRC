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

        // Accept float quantities (for money amounts) and preserve decimals
        return $st->execute([
            (string)$nom,
            (float)$quantite,
            (int)$id
        ]);
    }

    /**
     * Return total amount (quantite) for donations named 'Argent'
     */
    public function getTotalMoney()
    {
        $st = $this->pdo->prepare("SELECT SUM(quantite) as total FROM BNGRC_dons WHERE LOWER(TRIM(nom)) = 'argent'");
        $st->execute();
        $row = $st->fetch(PDO::FETCH_ASSOC);
        return isset($row['total']) ? (float)$row['total'] : 0.0;
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
            SELECT * FROM BNGRC_dons ORDER BY date_don ASC
        ");

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateQuantite($id, $nouvelleQuantite)
    {
        $sql = "UPDATE BNGRC_dons SET quantite = ? WHERE id = ?";
        
        $params = [
            (int)$nouvelleQuantite,
            (int)$id
        ];
        
        $st = $this->pdo->prepare($sql);
        return $st->execute($params);
    }
}
