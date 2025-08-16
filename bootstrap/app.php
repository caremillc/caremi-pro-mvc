<?php declare(strict_types=1);

use Careminate\Support\EnvLoader;

/*
|--------------------------------------------------------------------------
| Bootstrap Application
|--------------------------------------------------------------------------
| Validate PHP version & load the environment variables before starting.
|--------------------------------------------------------------------------
*/

// Minimum PHP version
if (version_compare(PHP_VERSION, '8.3.0', '<')) {
    header('Content-Type: text/plain');
    exit("PHP 8.2 or higher is required. Current version: " . PHP_VERSION);
}

// Load .env into $_ENV / $_SERVER
EnvLoader::load(BASE_PATH);

echo 'Bootstrap app loaded.' . PHP_EOL;
