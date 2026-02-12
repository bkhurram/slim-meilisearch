<?php

declare(strict_types=1);

use App\Command\MeiliSearchTaskCommand;
use App\Command\ProductReindexCommand;
use DI\Container;
use Symfony\Component\Console\Application;

/* Registers global commands in the CLI application. */
return static function (Container $container): void {
    /** @var Application $app */
    $app = $container->get(Application::class);
    $app->addCommand($container->get(ProductReindexCommand::class));
    $app->addCommand($container->get(MeiliSearchTaskCommand::class));
};
