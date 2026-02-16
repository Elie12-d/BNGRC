<?php

namespace app\controllers;

use app\models\BesoinsModel;
use app\models\RegionsModel;
use app\models\VillesModel;
use app\models\DonsModel;
use app\models\DispatchModel;
//session_start();
use flight\Engine;

class DashboardController
{

	protected Engine $app;

	public function __construct($app)
	{
		$this->app = $app;
	}
	public function dashboard()
	{
		$villes = new VillesModel();
		$villes = $villes->getAll();
		$regions = new RegionsModel();
		$regions = $regions->getAll();
		$dons = new DonsModel();
		$dons = $dons->getAll();
		$besoins = new BesoinsModel();
		$besoins = $besoins->getAll();
		$dispatchModel = new DispatchModel();
		$dispatchs = $dispatchModel->getAll();

		foreach ($besoins as &$besoin) {
			$besoin['attribue'] = 0;
			foreach ($dispatchs as $dispatch) {
				if (
					$dispatch['id_besoin'] == $besoin['id'] &&
					in_array($dispatch['status'], ['complete', 'partiel', 'en_cours'])
				) {
					$besoin['attribue'] += $dispatch['quantite_attribuee'];
				}
			}
			$besoin['reste'] = $besoin['quantite'] - $besoin['attribue'];
			$besoin['statut'] = $this->getStatutSimple($besoin['quantite'], $besoin['attribue']);
		}
		$this->app->render('dashboard', [
			'villes' => $villes,
			'besoins' => $besoins,
			'dispatchs' => $dispatchs
		]);
	}
	private function getStatutSimple($quantite, $attribue)
	{
		if ($attribue == 0) return ['class' => 'danger', 'label' => '❌ Non traité'];
		if ($attribue >= $quantite) return ['class' => 'success', 'label' => '✅ Complété'];
		return ['class' => 'warning', 'label' => '⚠️ Partiellement'];
	}
}