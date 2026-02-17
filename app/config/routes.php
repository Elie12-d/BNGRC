<?php

use app\controllers\AutoDispatchController;
use app\controllers\DashboardController;
use app\controllers\BngrcController;
use app\controllers\DispatchController;
use app\controllers\RecapitulatifController;
use app\controllers\AchatController;
use app\controllers\ResetController;
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
// $router->get('/disp', [ AutoDispatchController::class, 'autoDispatchByOrderDemande' ]);
$router->group('/dispatch', function(Router $router) {
	$router->get('/auto-by-demande', [ AutoDispatchController::class, 'autoDispatchByOrderDemande' ]);
	$router->get('/auto-by-quantity', [ AutoDispatchController::class, 'autoDispatchByOrderMinQuantity' ]);
	
});
$router->get('/reset', [ ResetController::class, 'reset' ]);
// Show the dispatch (purchase) form at /dispatch
$router->get('/dispatch', [ DispatchController::class, 'showForm' ]);
// Handle validation/submit from the purchase form
$router->post('/achat/validate', [ DispatchController::class, 'validate' ]);
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
			$app->render('', ['villes' => $villes, 'products' => $products ?? [], 'page' => 'besoins']);
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
			$app->render('model', ['products' => $products, 'page' => 'form_don']);
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
	$router->group('/recapitulatif', function(Router $router) use ($app) {
		$router->get('', [ RecapitulatifController::class, 'showRecapitulatif' ]);
		$router->get('/refresh', [ RecapitulatifController::class, 'refresh' ]);
	});
	$router->group('/achat', function(Router $router) use ($app) {
		$router->get('/historique', [ AchatController::class, 'historique' ]);
	});
});