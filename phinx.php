<?php

declare(strict_types=1);

return [
    'paths' => [
        'migrations' => __DIR__ . '/database/migrations',
        'seeds'      => __DIR__ . '/database/seeds',
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment'     => getenv('PHINX_ENV') ?: 'development',
        'development'             => [
            'adapter'   => 'mysql',
            'host'      => getenv('DB_HOST') ?: 'db',
            'name'      => getenv('DB_DATABASE') ?: 'slim_demo',
            'user'      => getenv('DB_USERNAME') ?: 'app',
            'pass'      => getenv('DB_PASSWORD') ?: 'app_pass',
            'port'      => (int) (getenv('DB_PORT') ?: 3306),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],
    ],
    'version_order' => 'creation',
];
