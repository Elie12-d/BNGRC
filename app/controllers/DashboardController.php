<?php

namespace app\controllers;

use app\models\RegionsModel;
use app\models\VillesModel;
use app\models\DonsModel;
//session_start();
use flight\Engine;

class DashboardController
{

	protected Engine $app;

	public function __construct($app)
	{
		$this->app = $app;
	}
	public function dashboard() {
		$villes = new VillesModel();
		$villes = $villes->getAll();
		$regions = new RegionsModel();
		$regions = $regions->getAll();
		$dons = new DonsModel();
		$dons = $dons->getAll();
		$besoins = new DonsModel();
		$besoins = $besoins->getAll();
		$this->app->render('dashboard', [
			'villes' => $villes,
			'regions' => $regions,
			'dons' => $dons,
			'besoins' => $besoins
		]);
	}
}