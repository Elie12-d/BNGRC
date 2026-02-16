<?php

use app\controllers\DashboardController;
use flight\Engine;
use flight\net\Router;

	/** 
	 * @var Router $router 
	 * @var Engine $app
	 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {
	$router->get('/Dashboard', [ DashboardController::class, 'dashboard' ]);

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