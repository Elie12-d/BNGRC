<?php

namespace app\controllers;

use app\models\AchatModel;
use Flight;
use flight\Engine;

class AchatController {

    public function historique() {

        $model = new AchatModel(Flight::db());
        $achats = $model->getAll();

        Flight::render('model', [
            'achats' => $achats,
            'page' => 'historique'
        ]);
    }
}
