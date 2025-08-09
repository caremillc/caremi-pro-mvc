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

// bootstrapping
// require BASE_PATH . '/bootstrap/app.php';
$bootstrapFiles = glob(BASE_PATH . '/bootstrap/*.php');
sort($bootstrapFiles); // sort alphabetically
foreach ($bootstrapFiles as $file) {
    require_once $file;
}

// Bootstrap the application
try {
    // Set JSON serializer once
    Response::setJsonSerializer(function ($data) {
        return json_encode($data, JSON_PRETTY_PRINT | Response::getJsonOptions());
    });

    // Route handling would go here
    $response = Response::json([
        'app' => env('APP_NAME'),
        'debug' => env('APP_DEBUG'),
        'time' => round(microtime(true) - APP_START, 4),
        'status' => 'OK'
    ]);

    // send response (string of content)
   // $content  = '<h1>Hello World from index page</h1>';
   // $response = new Response(content: $content, status: 200, headers: []);
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


