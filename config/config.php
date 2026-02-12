<?php

declare(strict_types=1);

use DI\Container;

return static function (Container $container): void {
    $config = [
        'app' => [
            'name'  => (string) (getenv('APP_NAME') ?: 'Luxos Search API'),
            'env'   => (string) (getenv('APP_ENV') ?: 'local'),
            'debug' => filter_var(getenv('APP_DEBUG') ?: '1', FILTER_VALIDATE_BOOL),
        ],
        'db' => [
            'host'     => (string) (getenv('DB_HOST') ?: 'db'),
            'port'     => (string) (getenv('DB_PORT') ?: '3306'),
            'database' => (string) (getenv('DB_DATABASE') ?: 'slim_demo'),
            'username' => (string) (getenv('DB_USERNAME') ?: 'app'),
            'password' => (string) (getenv('DB_PASSWORD') ?: 'app_pass'),
        ],
        'meili' => [
            'host'       => (string) (getenv('MEILI_HOST') ?: 'http://meilisearch:7700'),
            'master_key' => (string) (getenv('MEILI_MASTER_KEY') ?: 'masterKey123'),
        ],
        'log' => [
            'channel' => (string) (getenv('LOG_CHANNEL') ?: 'app'),
            'level'   => (string) (getenv('LOG_LEVEL') ?: 'INFO'),
        ],
    ];

    $container->set('config', $config);
    $container->set('app.name', (string) ($config['app']['name'] ?? 'Luxos Search API'));
    $container->set('app.env', (string) ($config['app']['env'] ?? 'local'));
    $container->set('app.debug', (bool) ($config['app']['debug'] ?? true));
    $container->set('db', (array) ($config['db'] ?? []));
    $container->set('meili', (array) ($config['meili'] ?? []));
    $container->set('log', (array) ($config['log'] ?? []));
};
