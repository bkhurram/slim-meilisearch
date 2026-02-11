<?php

declare(strict_types=1);

use App\Handler\HealthHandler;
use App\Handler\MetadataFieldsHandler;
use App\Handler\ProductsFiltersHandler;
use App\Handler\ProductsListHandler;
use App\Handler\ProductsReindexHandler;
use App\Handler\ProductsSearchHandler;
use App\Service\ProductService;
use App\Service\SearchService;
use DI\Container;
use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;

return static function (Container $container): void {
    /** @var App $app */
    $app = $container->get(App::class);

    $container->set(HealthHandler::class, fn() => new HealthHandler());
    $container->set(ProductsListHandler::class, fn(ContainerInterface $c) => new ProductsListHandler($c->get(ProductService::class)));
    $container->set(MetadataFieldsHandler::class, fn(ContainerInterface $c) => new MetadataFieldsHandler($c->get(ProductService::class)));
    $container->set(ProductsFiltersHandler::class, fn(ContainerInterface $c) => new ProductsFiltersHandler($c->get(ProductService::class)));
    $container->set(ProductsReindexHandler::class, fn(ContainerInterface $c) => new ProductsReindexHandler($c->get(ProductService::class), $c->get(SearchService::class)));
    $container->set(ProductsSearchHandler::class, fn(ContainerInterface $c) => new ProductsSearchHandler($c->get(SearchService::class)));

    $app->group('/api', function (RouteCollectorProxyInterface $group) {
        $group->get('/health', HealthHandler::class);
        $group->get('/products', ProductsListHandler::class);
        $group->get('/metadata-fields', MetadataFieldsHandler::class);
        $group->get('/filters', ProductsFiltersHandler::class);
        $group->post('/reindex', ProductsReindexHandler::class);
        $group->get('/search', ProductsSearchHandler::class);
    });
};
