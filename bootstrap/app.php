<?php declare(strict_types=1);
use Dotenv\Dotenv;
use Careminate\Support\EnvManager;
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

load_env();

EnvManager::validateAppKey(env('APP_KEY'));

throw new \Careminate\Logs\Log("Route '{$uri}' not found", 404);
