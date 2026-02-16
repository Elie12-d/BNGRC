<?php

namespace app\models;

use Flight;
use PDO;

class UsersModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Flight::db();
    }

    public function create($username, $password, $type = 'user')
    {
        $st = $this->pdo->prepare("
            INSERT INTO BNGRC_users(username, password, type)
            VALUES(?, ?, ?)
        ");

        $st->execute([
            (string)$username,
            password_hash((string)$password, PASSWORD_DEFAULT),
            (string)$type
        ]);

        return $this->pdo->lastInsertId();
    }

    public function getAll()
    {
        $st = $this->pdo->query("SELECT * FROM BNGRC_users");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $st = $this->pdo->prepare("
            SELECT * FROM BNGRC_users WHERE id = ?
        ");

        $st->execute([(int)$id]);

        return $st->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $username, $type)
    {
        $st = $this->pdo->prepare("
            UPDATE BNGRC_users
            SET username = ?, type = ?
            WHERE id = ?
        ");

        return $st->execute([
            (string)$username,
            (string)$type,
            (int)$id
        ]);
    }

    public function delete($id)
    {
        $st = $this->pdo->prepare("
            DELETE FROM BNGRC_users WHERE id = ?
        ");

        return $st->execute([(int)$id]);
    }
}
