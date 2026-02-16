<?php

namespace app\controllers;

use app\models\AchatModel;
use app\models\DonsModel;
use Flight;
use flight\Engine;

class AchatController {

    public function historique() {

        $model = new AchatModel(Flight::db());
        $achats = $model->getAll();

        Flight::render('achat/historique', [
            'achats' => $achats
        ]);
    }
}
