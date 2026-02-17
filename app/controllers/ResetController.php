<?php

namespace app\controllers;

use flight\Engine;
use app\models\AchatModel;
use app\models\BesoinsModel;
use app\models\BngrcModel;
use app\models\DispatchModel;
use app\models\DonsModel;
use app\models\RegionsModel;
use app\models\UsersModel;
use app\models\VillesModel;
use Flight;

class ResetController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }
    public function reset()
    {
        $besoinModel = new BesoinsModel();
        $dispatchModel = new DispatchModel();
        $donsModel = new DonsModel();
        $regionsModel = new RegionsModel();
        $usersModel = new UsersModel();
        $villesModel = new VillesModel();
        $achatModel = new AchatModel();
        $this->setOffCheckForeignKey();
        $achatModel->reset();
        $besoinModel->reset();
        $dispatchModel->reset();
        $donsModel->reset();
        $regionsModel->reset();
        $usersModel->reset();
        $villesModel->reset();
        $this->setOnCheckForeignKey();
        $this->insertData();
        $this->app->redirect('/dashboard');
    }
    public function setOffCheckForeignKey()
    {
        Flight::db()->exec("SET FOREIGN_KEY_CHECKS = 0");
    }
    public function setOnCheckForeignKey()
    {
        Flight::db()->exec("SET FOREIGN_KEY_CHECKS = 1");
    }
    public function insertData()
    {
        Flight::db()->exec("INSERT INTO BNGRC_users (username, password, type) VALUES
            ('admin', MD5('admin123'), 'admin'),
            ('rakoto', MD5('rakoto123'), 'user'),
            ('rabe', MD5('rabe123'), 'user'),
            ('coordinator', MD5('coord123'), 'admin')");

        Flight::db()->exec("INSERT INTO BNGRC_regions (nom) VALUES
            ('Analamanga'),
            ('Atsinanana'),
            ('Boeny')");
        Flight::db()->exec("INSERT INTO BNGRC_villes (nom, id_region) VALUES
            ('Antananarivo', 1),
            ('Ambohidratrimo', 1),
            ('Toamasina', 2),
            ('Brickaville', 2),
            ('Mahajanga', 3),
            ('Marovoay', 3)");
        Flight::db()->exec("INSERT INTO BNGRC_besoins (nom, quantite, prix_unitaire, id_ville, date_creation) VALUES
            ('Riz', 500, 2500, 1, '2026-02-10 08:00:00'),
            ('Huile', 100, 7800, 1, '2026-02-10 08:00:00'),
            ('Tôle', 50, 42000, 1, '2026-02-10 08:00:00'),

            ('Riz', 300, 2800, 3, '2026-02-11 09:00:00'),
            ('Tôle', 80, 45000, 3, '2026-02-11 09:00:00'),
            ('Bâche', 30, 38000, 3, '2026-02-11 09:00:00'),

            ('Riz', 400, 2500, 5, '2026-02-12 10:00:00'),
            ('Farine', 200, 2800, 5, '2026-02-12 10:00:00'),
            ('Huile', 80, 7500, 5, '2026-02-12 10:00:00'),
            ('Sucre', 100, 4000, 5, '2026-02-12 10:00:00')");
        Flight::db()->exec("INSERT INTO BNGRC_dons (nom, quantite, date_don) VALUES
            ('Riz', 600, '2026-02-09'),
            ('Huile', 150, '2026-02-09'),
            ('Tôle', 100, '2026-02-09'),

            ('Riz', 400, '2026-02-10'),
            ('Argent', 1000000, '2026-02-10'),
            ('Bâche', 50, '2026-02-10'),

            ('Riz', 300, '2026-02-11'),
            ('Farine', 150, '2026-02-11'),
            ('Sucre', 80, '2026-02-11'),

            ('Tôle', 70, '2026-02-12')");
        Flight::db()->exec("INSERT INTO BNGRC_dispatch (id_don, id_besoin, quantite_attribuee, status, date_dispatch) VALUES
            (1, 1, 400, 'complete', '2026-02-10 10:30:00'),
            (1, 4, 200, 'partiel', '2026-02-10 10:30:01'),

            (2, 2, 100, 'complete', '2026-02-11 09:15:00'),

            (3, 3, 50, 'complete', '2026-02-11 14:20:00'),
            (3, 5, 30, 'partiel', '2026-02-11 14:20:01')");
    }
}
