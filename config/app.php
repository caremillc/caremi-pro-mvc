<?php declare(strict_types=1);

return [
    'name' => $_ENV['APP_NAME'] ?? 'Careminate',
    'env' => $_ENV['APP_ENV'] ?? 'production',
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOL),
    'version' => $_ENV['APP_VERSION'] ?? '1.0.0',
    'url' => $_ENV['APP_URL'] ?? 'http://localhost',
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    
    'aliases' => [
        'Response' => Careminate\Http\Responses\Response::class,
        'Redirect' => Careminate\Http\Responses\RedirectResponse::class,
    ],

    'providers' => [
        // Service providers will be added here
    ],
];