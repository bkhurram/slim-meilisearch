<?php

declare(strict_types=1);

use App\Command\ProductReindexCommand;
use App\Core\LocalizationMiddleware;
use App\Repository\DatabaseConnectionFactory;
use App\Service\ProductService;
use App\Service\SearchService;
use DI\Container;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Symfony\Component\Console\Application;

/* Registers global dependencies in the container. */
return static function (Container $container): void {
    $container->set(ResponseFactoryInterface::class, static fn (Container $c) => $c->get(Psr17Factory::class));
    $container->set(App::class, static function (Container $c): App {
        AppFactory::setContainer($c);
        AppFactory::setResponseFactory($c->get(ResponseFactoryInterface::class));

        return AppFactory::create();
    });

    // console application
    $container->set(Application::class, static fn (Container $c) => new Application((string) $c->get('app.name'), '1.0.0'));

    $container->set(LoggerInterface::class, static function (ContainerInterface $c): LoggerInterface {
        $log = (array) $c->get('log');
        $level = Level::fromName((string) ($log['level'] ?? 'INFO'));

        $logger = new Logger((string) ($log['channel'] ?? 'app'));
        $logger->pushHandler(new StreamHandler('php://stdout', $level));

        return $logger;
    });

    $container->set(DatabaseConnectionFactory::class, static fn (ContainerInterface $c) => new DatabaseConnectionFactory((array) $c->get('db')));
    $container->set(ProductService::class, static fn (ContainerInterface $c) => new ProductService($c->get(DatabaseConnectionFactory::class)));
    $container->set(SearchService::class, static fn (ContainerInterface $c) => new SearchService((array) $c->get('meili')));

    // Commands
    $container->set(ProductReindexCommand::class, static fn (ContainerInterface $c) => new ProductReindexCommand(
        $c->get(ProductService::class),
        $c->get(SearchService::class)
    ));

    // Middleware
    $container->set(LocalizationMiddleware::class, fn (ContainerInterface $c) => new LocalizationMiddleware(
        languages: ['en', 'it'],
    ));
};
