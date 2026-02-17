<?php

namespace app\models;

use Flight;
use PDO;

class DispatchModel
{
    private $pdo;
    private $db;

    public function __construct()
    {
        $this->pdo = Flight::db();
    }
    public function create($id_don, $id_besoin, $quantite_attribuee, $status)
    {
        $st = $this->pdo->prepare("
            INSERT INTO BNGRC_dispatch(id_don, id_besoin, quantite_attribuee, status, date_dispatch)
            VALUES(?, ?, ?, ?, NOW())
        ");

        $st->execute([
            (int)$id_don,
            (int)$id_besoin,
            (int)$quantite_attribuee,
            (string)$status
        ]);

        return $this->pdo->lastInsertId();
    }
    public function getAll()
    {
        $st = $this->pdo->query("SELECT * FROM BNGRC_dispatch");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTotalByBesoin($id_besoin)
    {
        $st = $this->pdo->prepare("
            SELECT SUM(quantite_attribuee) as total
            FROM BNGRC_dispatch
            WHERE id_besoin = ? AND status IN ('complete', 'partiel')
        ");

        $st->execute([(int)$id_besoin]);
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
    public function getTotalSatisfaits()
    {
        $st = $this->pdo->query("
        SELECT SUM(d.quantite_attribuee * b.prix_unitaire) as total
        FROM BNGRC_dispatch d
        JOIN BNGRC_besoins b ON d.id_besoin = b.id
        WHERE d.status IN ('complete', 'partiel')
    ");
        $result = $st->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
    public function reset()
    {
        $stmt = $this->pdo->prepare("DELETE FROM BNGRC_dispatch");
        $stmt->execute();
        $stmt = $this->pdo->prepare("ALTER TABLE BNGRC_dispatch AUTO_INCREMENT = 1");
        $stmt->execute();
    }
}
