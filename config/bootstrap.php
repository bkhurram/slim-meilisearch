<?php

declare(strict_types=1);

use DI\Container;
use DI\ContainerBuilder;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$envPath = __DIR__ . '/../.env';
if (is_file($envPath)) {
    (new Dotenv())->usePutenv()->loadEnv($envPath);
}

date_default_timezone_set((string) (getenv('APP_TIMEZONE') ?: 'UTC'));
error_reporting(E_ALL);
ini_set('log_errors', '1');
ini_set('default_charset', 'UTF-8');
ini_set('display_errors', (getenv('APP_ENV') ?: 'local') === 'local' ? '1' : '0');
ini_set('error_log', (string) (getenv('PHP_ERROR_LOG') ?: '/tmp/php-errors.log'));
ini_set('upload_max_filesize', (string) (getenv('UPLOAD_MAX_FILESIZE') ?: '256M'));
ini_set('post_max_size', (string) (getenv('POST_MAX_SIZE') ?: '256M'));

$builder = new ContainerBuilder();
/** @var Container $container */
$container = $builder->build();

$files = [
    __DIR__ . '/config.php',
    __DIR__ . '/dependencies.php',
    __DIR__ . '/routes.php',
    __DIR__ . '/commands.php',
    __DIR__ . '/middleware.php',
];

foreach ($files as $file) {
    $setup = require_once $file;
    $setup($container);
}

return $container;
