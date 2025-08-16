<?php declare (strict_types = 1); // public/index.php

use Careminate\Http\Responses\Response;

// Define application constants
define('APP_START', microtime(true));   // Application start time for performance tracking
define('BASE_PATH', dirname(__DIR__));  // Base directory path
define('ROOT_PATH', dirname(__FILE__)); // Root directory path
define('ROOT_DIR', dirname(__FILE__));
define('PUBLIC_PATH', __DIR__); // public directory path

// Ensure minimum PHP version
if (version_compare(PHP_VERSION, '8.1.0', '<')) {
    header('Content-Type: text/plain');
    die("PHP 8.1 or higher is required. Current version: " . PHP_VERSION);
}
//ensure .env file exists
if (! file_exists(BASE_PATH . '/.env')) {
    throw new RuntimeException('Please create a .env file');
}

// ✅ Load Composer Autoload FIRST
require_once BASE_PATH . '/vendor/autoload.php';

// Bootstrapping in a controlled order
require_once BASE_PATH . '/bootstrap/app.php';
require_once BASE_PATH . '/bootstrap/performance.php';

// Bootstrap the application
try {
    // Set JSON serializer once
    Response::setJsonSerializer(function ($data) {
        return json_encode($data, JSON_PRETTY_PRINT | Response::getJsonOptions());
    });

    // response handling would go here
    // $response = Response::json([
    //     'app'    => config('app.name'),
    //     'debug'  => config('app.debug'),
    //     'env'    => config('app.env'),
    //     'time'   => round(microtime(true) - APP_START, 4),
    //     'status' => 'OK',
    // ]);

    // send response (string of content)
    $content  = '<h1>Hello World from index page</h1>';
    $response = new Response(content: $content, status: 200, headers: []);
    $response->send();

} catch (Throwable $e) {
    // Log the error
    error_log($e->getMessage());

    // Show error response
    if ($_ENV['APP_DEBUG'] ?? false) {
        $response = Response::json([
            'error' => $e->getMessage(),
            'trace' => $e->getTrace(),
        ], 500);
    } else {
        $response = new Response('Internal Server Error', 500);
    }

    $response->send();
    exit(1);
}


