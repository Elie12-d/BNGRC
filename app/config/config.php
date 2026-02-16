<?php
/**********************************************
 *      FlightPHP Skeleton Config Sample      *
 **********************************************/

/**********************************************
 *         Application Environment            *
 **********************************************/
// Set your timezone
date_default_timezone_set('UTC');

// Error reporting level (recommended for development)
error_reporting(E_ALL);

// Character encoding
if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding('UTF-8');
}

// Default Locale (optional)
if (function_exists('setlocale')) {
    setlocale(LC_ALL, 'en_US.UTF-8');
}

/**********************************************
 *           FlightPHP Core Settings          *
 **********************************************/

// Get the $app var
if (empty($app)) {
    $app = Flight::app();
}

// Directory separator
$ds = DIRECTORY_SEPARATOR;

// Autoload your code
$app->path(__DIR__ . $ds . '..' . $ds . '..');

// Base URL for your app (important)
$app->set('flight.base_url', '');

// Define BASE_URL constant safely
if (!defined('BASE_URL')) {
    define('BASE_URL', $app->get('flight.base_url'));
}

// Other Flight settings
$app->set('flight.case_sensitive', false);
$app->set('flight.log_errors', true);
$app->set('flight.handle_errors', false);
$app->set('flight.views.path', __DIR__ . $ds . '..' . $ds . 'views');
$app->set('flight.views.extension', '.php');
$app->set('flight.content_length', false);

// Generate a CSP nonce for each request
$nonce = bin2hex(random_bytes(16));
$app->set('csp_nonce', $nonce);

/**********************************************
 *           User Configuration               *
 **********************************************/
return [
    'database' => [
        'host'     => '127.0.0.1',
        'dbname'   => 'revision_final_s3',
        'user'     => 'root',
        'password' => '',
    ],
    // Add more configuration sections here if needed
];
