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
        $this->app->render('recapitulation', ['total' => $total, 'total_satisfait' => $total_satisfait]);
    }
}