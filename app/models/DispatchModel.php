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
    public function getAll()
    {
        $st = $this->pdo->query("SELECT * FROM BNGRC_dispatch");
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }
}
