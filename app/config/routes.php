<?php

use app\controllers\AutoDispatchController;
use app\controllers\DashboardController;
use app\controllers\BngrcController;
use app\controllers\RecapitulatifController;
use app\controllers\AchatController;
use flight\Engine;
use flight\net\Router;

	/** 
	 * @var Router $router 
	 * @var Engine $app
	 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {
// Make dashboard available at '/', '/home' and '/dashboard' (case-insensitive matching configured)
$router->get('/', [ DashboardController::class, 'dashboard' ]);
$router->get('/home', [ DashboardController::class, 'dashboard' ]);
$router->get('/dashboard', [ DashboardController::class, 'dashboard' ]);

// Other routes
$router->get('/disp', [ AutoDispatchController::class, 'autoDispatch' ]);
$router->get('/achat/historique', [ AchatController::class, 'historique' ]);


	// Backwards-compat / convenience: redirect /villes to the besoins form (or implement list later)
	$router->get('/villes', function() use ($app) {
		// If you want a dedicated villes page later, replace this redirect by a renderer
		$app->redirect('/besoins');
	});

	// Besoins & Dons routes (forms + submission)
	if (class_exists(\app\controllers\BngrcController::class)) {
		$router->get('/besoins', [ BngrcController::class, 'showBesoinForm' ]);
		$router->post('/besoin/save', [ BngrcController::class, 'submitBesoin' ]);

		$router->get('/dons', [ BngrcController::class, 'showDonForm' ]);
		$router->post('/don/save', [ BngrcController::class, 'submitDon' ]);
	} else {
		// fallback closures if controller class isn't autoloaded for any reason
		$router->get('/besoins', function() use ($app) {
			$villes = [];
			try {
				$model = new \app\models\BngrcModel(\Flight::db());
				$villes = $model->getVilles();
				$products = [];
				try { $products = $model->getProducts(); } catch (\Throwable $_) { }
			} catch (\Throwable $e) {
				// ignore, view will show empty list
			}
			$app->render('form_besoin', ['villes' => $villes, 'products' => $products ?? []]);
		});

		$router->post('/besoin/save', function() use ($app) {
			$data = \Flight::request()->data;
			try {
				$model = new \app\models\BngrcModel(\Flight::db());
				$model->saveBesoin($data->nom, $data->quantite, $data->prix_unitaire, $data->id_ville);
			} catch (\Throwable $e) {
				// log or ignore
			}
		\Flight::redirect('/dashboard');
		});

		$router->get('/dons', function() use ($app) {
			$products = [];
			try {
				$model = new \app\models\BngrcModel(\Flight::db());
				$products = $model->getProducts();
			} catch (\Throwable $_) { }
			$app->render('form_don', ['products' => $products]);
		});

		$router->post('/don/save', function() use ($app) {
			$data = \Flight::request()->data;
			try {
				$model = new \app\models\BngrcModel(\Flight::db());
				$model->saveDon($data->nom, $data->quantite, $data->date_don);
			} catch (\Throwable $e) {
				// log or ignore
			}
		\Flight::redirect('/dashboard');
		});
	}
	$router->get('/recapitulatif', [ RecapitulatifController::class, 'showRecapitulatif' ]);
});