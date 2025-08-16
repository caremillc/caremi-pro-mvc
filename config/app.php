<?php declare(strict_types=1);
return [
    'name'  => env('APP_NAME', 'Careminate'),
    'debug' => env('APP_DEBUG', false),
    'env'   => env('APP_ENV', 'production'),
    'version'   => env('APP_VERSION') ?? '1.0.0',
    'url'       => env('APP_URL') ?? 'http://localhost',
    'timezone'  => 'UTC',
    'locale'    => 'en',
    'fallback_locale' => 'en',
    
    'aliases' => [
        //'Response' => Careminate\Http\Responses\Response::class,
        //'Redirect' => Careminate\Http\Responses\RedirectResponse::class,
    ],
];