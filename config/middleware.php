<?php

declare(strict_types=1);

use DI\Container;
use Psr\Log\LoggerInterface;
use Slim\App;

return static function (Container $container): void {
    /** @var App $app */
    $app = $container->get(App::class);

    $app->addBodyParsingMiddleware();
    $app->addErrorMiddleware(
        (bool) $container->get('app.debug'),
        true,
        true,
        $container->get(LoggerInterface::class)
    );
};
