<?php declare(strict_types=1);

return [
    'default' => env('LOG_CHANNEL', 'daily'),

    'display_errors' => env('APP_DEBUG', false),

    'channels' => [
        'single' => [
            'driver' => 'file',
            'path'   => storage_path('logs/log.log'),
        ],

        'daily' => [
            'driver' => 'daily',
            'path'   => storage_path('logs/log.log'),
            'date_format' => 'Y-m-d', // Optional
        ],
    ],
];