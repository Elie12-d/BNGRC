<?php

namespace app\controllers;

use app\models\BesoinsModel;
use app\models\DonsModel;
use app\models\DispatchModel;
//session_start();
use flight\Engine;

class RecapitulatifController
{

    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }
    public function showRecapitulatif()
    {
        $besoinsModel = new BesoinsModel();
        $dispatchModel = new DispatchModel();
        $total = $besoinsModel->getTotalBesoins();
        $total_satisfait = $dispatchModel->getTotalSatisfaits();
        $this->app->render('recapitulation', [
            'total_besoins' => $total,
            'total_satisfaits' => $total_satisfait,
            'besoin_restant' => $total - $total_satisfait
        ]);
    }
    public function refresh(){
        $besoinsModel = new BesoinsModel();
        $dispatchModel = new DispatchModel();
        $total = $besoinsModel->getTotalBesoins();
        $total_satisfait = $dispatchModel->getTotalSatisfaits();
        $sata = [
            'total_besoins' => $total,
            'total_satisfaits' => $total_satisfait,
            'besoin_restant' => $total - $total_satisfait
        ];
        echo json_encode($sata);
    }
}