<?php

use app\controllers\DashboardController;
use app\controllers\BngrcController;
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

	// $router->get('/', [ PagesController::class, 'init' ]);
	// $router->post('/login', [ PagesController::class, 'login' ]);
	// $router->get('/logout', [ PagesController::class, 'logout' ]);

	// $router->group('/category', function() use ($router) {
	// 	$router->get('/add', [ PagesController::class, 'addCategory' ]);
	// 	$router->post('/add', [ PagesController::class, 'addCategory' ]);
	// 	$router->get('/delete/@id:[0-9]+', [ PagesController::class, 'deleteCategory' ]);
	// 	$router->get('/update/@id:[0-9]+', [ PagesController::class, 'updateCategoryForm' ]);
	// 	$router->post('/update', [ PagesController::class, 'updateCategory' ]);
	// 	$router->get('/lists', [ PagesController::class, 'toLists' ]); // You would need to create this method in the controller and model to pull from the database
	// });
	// $router->get('/home', function() use ($app) {
	// 	$app->render('welcome');
	// });
	// $router->group('/products', function () use ($app, $router) {
	// 	$router->get('/lists', [ PagesController::class, 'products' ]);
	// 	$router->group('/exchange', function () use ($app, $router) {
	// 		$router->get('/propose', [ PagesController::class, 'proposeExchange' ]);
	// 		$router->post('/accept/@id:[0-9]+', [ PagesController::class, 'acceptProposition' ]);
	// 		$router->post('/reject/@id:[0-9]+', [ PagesController::class, 'rejectProposition' ]);
	// 	});
	// 	//$router->get('/exchange/propose', [ PagesController::class, 'exchange']);
	// 	$router->get('/propositionLists', [ PagesController::class, 'propositionLists']);
	// });
	// $router->group('/categories', function () use ($app, $router) {
	// 	$router->get('/lists', [ PagesController::class, 'toLists' ]);
	// });
	// $router->group('/myproducts', function () use ($app, $router) {
	// 	$router->get('/lists', [ PagesController::class, 'myProducts' ]);
	// });
});