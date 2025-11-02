<?php declare (strict_types = 1);

return [
    'default' => env('DB_CONNECTION', 'mysql'),

    'drivers' => [
        'sqlite' => [
            'driver'    => 'sqlite',
            'path'      => env('DB_SQLITE_PATH', 'storage/database.sqlite'),
            'ERRMODE'   => PDO::ATTR_ERRMODE,
            'EXCEPTION' => PDO::ERRMODE_EXCEPTION,
        ],
        'mysql'  => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', '127.0.0.1'),
            'port'      => env('DB_PORT', 3306),
            'database'  => env('DB_DATABASE', 'careminate'),
            'username'  => env('DB_USERNAME', 'root'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => env('DB_CHARSET', 'utf8mb4'),
            'collation' => env('DB_COLLATION', 'utf8mb4_unicode_ci'),
            'ERRMODE'   => PDO::ATTR_ERRMODE,
            'EXCEPTION' => PDO::ERRMODE_EXCEPTION,
        ],
        'pgsql'  => [
            'driver'     => 'pgsql',
            'host'       => env('DB_HOST', '127.0.0.1'),
            'port'       => env('DB_PORT', 5432),
            'database'   => env('DB_DATABASE', 'careminate'),
            'username'   => env('DB_USERNAME', 'postgres'),
            'password'   => env('DB_PASSWORD', ''),
            'charset'    => env('DB_CHARSET', 'utf8'),
            'sslmode'    => env('DB_SSLMODE', 'prefer'),
            'persistent' => env('DB_PERSISTENT', false),
            'ERRMODE'    => PDO::ATTR_ERRMODE,
            'EXCEPTION'  => PDO::ERRMODE_EXCEPTION,
        ],
    ],
];
