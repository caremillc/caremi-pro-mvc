<?php declare(strict_types=1);

// ---------------------------------------------------------
// Define application constants
// ---------------------------------------------------------
define('CAREMI_START', microtime(true));      // Application start time
define('BASE_PATH', dirname(__DIR__));        // Project base directory
define('BOOTSTRAP_PATH', __DIR__);            // Bootstrap directory
define('PUBLIC_PATH', BASE_PATH . '/public'); // Public directory

// ---------------------------------------------------------
// Load Composer's autoloader (if available)
// ---------------------------------------------------------
$autoloadPath = BASE_PATH . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    require $autoloadPath;
} else {
    die('Autoloader not found. Please run "composer install".');
}

// ---------------------------------------------------------
// Load performance utilities (logs execution time, etc.)
// ---------------------------------------------------------
require_once BOOTSTRAP_PATH . '/performance.php';


// ---------------------------------------------------------
// Simple .env loader
// ---------------------------------------------------------
//$envFile = __DIR__ . '/../.env';

$envFile = base_path('.env');
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) continue;
        if (!str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value, " \t\n\r\0\x0B\"'");
        putenv("{$key}={$value}");
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}


// ---------------------------------------------------------
// Register automatic shutdown handler for performance logging
// ---------------------------------------------------------
register_shutdown_function('logExecutionTime');

 