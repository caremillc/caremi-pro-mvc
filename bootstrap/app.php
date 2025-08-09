<?php declare(strict_types=1);
use Dotenv\Dotenv;

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

// Register the autoloader
require_once BASE_PATH . '/vendor/autoload.php';

// Set default timezone
date_default_timezone_set('UTC');

// Load environment variables
$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->safeLoad();

// Error reporting based on environment
if ($_ENV['APP_ENV'] === 'dev' || $_ENV['APP_DEBUG'] === 'true') {
    // for dev
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    //fro production
    error_reporting(E_ALL & ~E_DEPRECATED);
    ini_set('display_errors', '0');
}

// Validate required environment variables
$requiredKeys = ['APP_NAME', 'APP_ENV', 'APP_KEY','DB_HOST','DB_DATABASE','DB_USERNAME'];

$dotenv->required($requiredKeys)->notEmpty();


// Register service providers
$providers = [
    // Add your service providers here
];

// Optional: Initialize error handling
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

set_exception_handler(function(Throwable $e) {
    if ($_ENV['APP_DEBUG'] === 'true') {
        echo "<pre>";
        echo "Uncaught exception: " . get_class($e) . "\n";
        echo "Message: " . $e->getMessage() . "\n";
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
        echo "</pre>";
    } else {
        error_log("Uncaught exception: " . $e->getMessage());
        http_response_code(500);
        echo "An error occurred. Please try again later.";
    }
    exit(1);
});


