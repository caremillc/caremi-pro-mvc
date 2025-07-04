<?php declare(strict_types=1);

use Dotenv\Dotenv;
use Careminate\Encryption\Encrypter;

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

require BASE_PATH . '/vendor/autoload.php';

// Load all configured service providers (including Environment)
$config = [
    'providers' => require BASE_PATH . '/config/providers.php',
];

// Register each provider
foreach ($config['providers'] as $providerClass) {
    (new $providerClass())->register();
}


// auto generate env key
$appKey = env('APP_KEY');
$encrypter = new Encrypter($appKey);

// Optional: bind to container or global helper
$GLOBALS['encrypter'] = $encrypter;