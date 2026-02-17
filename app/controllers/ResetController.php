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
        Flight::db()->exec("INSERT INTO BNGRC_regions (nom) VALUES 
            ('Atsinanana'),      -- Pour Toamasina
            ('Vatovavy'),         -- Pour Mananjary
            ('Atsimo-Atsinanana'), -- Pour Farafangana
            ('Diana'),            -- Pour Nosy Be
            ('Menabe')");
        Flight::db()->exec("INSERT INTO BNGRC_villes (nom, id_region) VALUES 
            ('Toamasina', 1),
            ('Mananjary', 2),
            ('Farafangana', 3),
            ('Nosy Be', 4),
            ('Morondava', 5)");
        Flight::db()->exec("INSERT INTO BNGRC_category (nom) VALUES 
            ('nature'),
            ('materiel'),
            ('argent')");
        Flight::db()->exec("INSERT INTO BNGRC_besoins (nom, quantite, date_saisie, prix_unitaire, id_ville, date_creation) VALUES 
            -- Toamasina (id_ville = 1)
            ('Riz (kg)', 800, '2026-02-16', 3000, 1, '2026-02-16'),
            ('Eau (L)', 1500, '2026-02-15', 1000, 1, '2026-02-15'),
            ('Tôle', 120, '2026-02-16', 25000, 1, '2026-02-16'),
            ('Bâche', 200, '2026-02-15', 15000, 1, '2026-02-15'),
            ('Argent', 12000000, '2026-02-16', 1, 1, '2026-02-16'),
            ('groupe', 3, '2026-02-15', 6750000, 1, '2026-02-15'),

            -- Mananjary (id_ville = 2)
            ('Riz (kg)', 500, '2026-02-15', 3000, 2, '2026-02-15'),
            ('Huile (L)', 120, '2026-02-16', 6000, 2, '2026-02-16'),
            ('Tôle', 80, '2026-02-15', 25000, 2, '2026-02-15'),
            ('Clous (kg)', 60, '2026-02-16', 8000, 2, '2026-02-16'),
            ('Argent', 6000000, '2026-02-15', 1, 2, '2026-02-15'),

            -- Farafangana (id_ville = 3)
            ('Riz (kg)', 600, '2026-02-16', 3000, 3, '2026-02-16'),
            ('Eau (L)', 1000, '2026-02-15', 1000, 3, '2026-02-15'),
            ('Bâche', 150, '2026-02-16', 15000, 3, '2026-02-16'),
            ('Bois', 100, '2026-02-15', 10000, 3, '2026-02-15'),
            ('Argent', 8000000, '2026-02-16', 1, 3, '2026-02-16'),

            -- Nosy Be (id_ville = 4)
            ('Riz (kg)', 300, '2026-02-15', 3000, 4, '2026-02-15'),
            ('Haricots', 200, '2026-02-16', 4000, 4, '2026-02-16'),
            ('Tôle', 40, '2026-02-15', 25000, 4, '2026-02-15'),
            ('Clous (kg)', 30, '2026-02-16', 8000, 4, '2026-02-16'),
            ('Argent', 4000000, '2026-02-15', 1, 4, '2026-02-15'),

            -- Morondava (id_ville = 5)
            ('Riz (kg)', 700, '2026-02-16', 3000, 5, '2026-02-16'),
            ('Eau (L)', 1200, '2026-02-15', 1000, 5, '2026-02-15'),
            ('Bâche', 180, '2026-02-16', 15000, 5, '2026-02-16'),
            ('Bois', 150, '2026-02-15', 10000, 5, '2026-02-15'),
            ('Argent', 10000000, '2026-02-16', 1, 5, '2026-02-16')");
        Flight::db()->exec("INSERT INTO BNGRC_dons (nom, quantite, id_category, date_don) VALUES 
            -- Dons du 2026-02-16
            ('Argent', 5000000, 3, '2026-02-16'),
            ('Argent', 3000000, 3, '2026-02-16'),
            ('Riz (kg)', 400, 1, '2026-02-16'),
            ('Eau (L)', 600, 1, '2026-02-16'),

            -- Dons du 2026-02-17
            ('Argent', 4000000, 3, '2026-02-17'),
            ('Argent', 1500000, 3, '2026-02-17'),
            ('Argent', 6000000, 3, '2026-02-17'),
            ('Tôle', 50, 2, '2026-02-17'),
            ('Bâche', 70, 2, '2026-02-17'),
            ('Haricots', 100, 1, '2026-02-17'),
            ('Haricots', 88, 1, '2026-02-17'),

            -- Dons du 2026-02-18
            ('Riz (kg)', 2000, 1, '2026-02-18'),
            ('Tôle', 300, 2, '2026-02-18'),
            ('Eau (L)', 5000, 1, '2026-02-18'),

            -- Dons du 2026-02-19
            ('Argent', 20000000, 3, '2026-02-19'),
            ('Bâche', 500, 2, '2026-02-19');");
    }
}
