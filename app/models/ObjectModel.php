<?php

namespace app\models;

use Flight;
use PDO;

class ObjectModel
{
    private $db;
    private $id;
    private $name;
    private $description;
    private $userId;
    private $categoryId;
    private $publishedDate;
    public function __construct()
    {
        $this->db = Flight::db();
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getUserId()
    {
        return $this->userId;
    }
    public function getCategoryId()
    {
        return $this->categoryId;
    }
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }
    public function getAllObjects($userId)
    {
        $sql = "SELECT * FROM objects WHERE user_id != ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function getObjectsByUserId($userId)
    {
        $sql = "SELECT * FROM objects WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function proposeExchange($userId1, $userId2, $objectId2, $objectId1)
    {
        try {
            $sql = "INSERT INTO exchanges(user1_id, user2_id, object1_id, object2_id, proposed_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$userId1, $userId2, $objectId1, $objectId2]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
    public function getUserIdById($id)
    {
        $sql = "SELECT user_id FROM objects WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }
    public function exchangeObjects($objectId1, $objectId2)
    {
        try {
            // Récupérer les propriétaires
            $stmt = $this->db->prepare("SELECT user_id FROM objects WHERE id = ?");
            $stmt->execute([$objectId1]);
            $owner1 = $stmt->fetchColumn();

            $stmt->execute([$objectId2]);
            $owner2 = $stmt->fetchColumn();

            // Échanger
            $stmt = $this->db->prepare("UPDATE objects SET user_id = ? WHERE id = ?");
            $stmt->execute([$owner2, $objectId1]);
            $stmt->execute([$owner1, $objectId2]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
    public function getReceivedPropositions($userId)
    {
        $sql = "SELECT * FROM exchanges WHERE user1_id = ? AND status = 'pending'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function getPropositionsByUserId($userId)
    {
        $sql = "SELECT * FROM exchanges WHERE user2_id = ? AND status = 'pending'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
    public function getAllPropositionsById($userId)
    {
        $sql = "SELECT * FROM exchanges WHERE user1_id = ? OR user2_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll();
    }
    public function deleteObject($id)
    {
        $sql = "UPDATE objects SET status = 'inactive' WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
    public function updateObject($id, $name, $description, $categoryId)
    {
        $sql = "UPDATE objects SET name = ?, description = ?, category_id = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $description, $categoryId, $id]);
    }
    public function addObject()
    {
        $sql = "INSERT INTO objects (name, description, user_id, category_id, published_date) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$this->name, $this->description, $this->userId, $this->categoryId]);
    }
    public function getObjectById($id)
    {
        $sql = "SELECT * FROM objects WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function acceptProposition($id)
    {
        try {
            $this->db->beginTransaction();

            // Récupérer la proposition
            $stmt = $this->db->prepare("SELECT * FROM exchanges WHERE id = ?");
            $stmt->execute([$id]);
            $proposition = $stmt->fetch();

            if (!$proposition) {
                throw new \Exception("Proposition not found");
            }

            // Échanger les objets
            $this->exchangeObjects($proposition['object1_id'], $proposition['object2_id']);

            // Mettre à jour le statut de la proposition
            $stmt = $this->db->prepare("UPDATE exchanges SET status = 'accepted', responded_at = NOW() WHERE id = ?");
            $stmt->execute([$id]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }
    public function rejectProposition($id)
    {
        $sql = "UPDATE exchanges SET status = 'rejected', responded_at = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }
}
