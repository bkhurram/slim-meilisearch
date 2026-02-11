<?php

declare(strict_types=1);

use Slim\App;

$container = require __DIR__ . '/../config/bootstrap.php';

/** @var App $app */
$app = $container->get(App::class);
$app->run();
