<?php

return [
    'default' => env('LOG_CHANNEL', 'single'),
    'display_errors' => env('APP_DEBUG', true),
    'channels' => [
        'single' => [
            'driver' => 'single',
            'path' => storage_path(env('LOG_PATH', 'logs/error.log')),
        ],
    ],
];