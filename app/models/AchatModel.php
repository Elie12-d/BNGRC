<?php
namespace app\models;
use PDO;
class AchatModel {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // CREATE
    public function create($id_don, $quantite, $prix_unitaire, $pourcentage) {
        $sql = "INSERT INTO BNGRC_achat (id_don, quantite, prix_unitaire, pourcentage)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id_don, $quantite, $prix_unitaire, $pourcentage]);
    }

    // READ ALL
    public function getAll() {
        $sql = "SELECT a.*, d.nom 
                FROM BNGRC_achat a
                JOIN BNGRC_dons d ON a.id_don = d.id";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ ONE
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM BNGRC_achat WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update($id, $id_don, $quantite, $prix_unitaire, $pourcentage) {
        $sql = "UPDATE BNGRC_achat 
                SET id_don=?, quantite=?, prix_unitaire=?, pourcentage=?
                WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id_don, $quantite, $prix_unitaire, $pourcentage, $id]);
    }

    // DELETE
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM BNGRC_achat WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
