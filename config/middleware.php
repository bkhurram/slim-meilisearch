<?php

declare(strict_types=1);

use App\Core\LocalizationMiddleware;
use DI\Container;
use Psr\Log\LoggerInterface;
use Slim\App;

return static function (Container $container): void {
    /** @var App $app */
    $app = $container->get(App::class);

    // Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Slim built-in body parsing middleware
    $app->addBodyParsingMiddleware();

    // Detects locale settings from headers and attaches them to the request as an attribute
    $app->add(LocalizationMiddleware::class);

    $app->addErrorMiddleware(
        (bool) $container->get('app.debug'),
        true,
        true,
        $container->get(LoggerInterface::class)
    );
};
