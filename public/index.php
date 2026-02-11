<?php

declare(strict_types=1);

use App\Database;
use App\ProductRepository;
use App\SearchService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->get('/health', function (Request $request, Response $response): Response {
    $response->getBody()->write(json_encode(['status' => 'ok'], JSON_THROW_ON_ERROR));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/products', function (Request $request, Response $response): Response {
    $query = $request->getQueryParams();
    $lang = (string) ($query['lang'] ?? 'en');
    $type = isset($query['type']) ? trim((string) $query['type']) : null;

    $products = (new ProductRepository(Database::connect()))->all($lang, $type);

    $response->getBody()->write(json_encode([
        'lang' => $lang,
        'type' => $type,
        'data' => $products,
    ], JSON_THROW_ON_ERROR));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/metadata-fields', function (Request $request, Response $response): Response {
    $query = $request->getQueryParams();
    $lang = (string) ($query['lang'] ?? 'en');
    $type = isset($query['type']) ? trim((string) $query['type']) : null;

    $fields = (new ProductRepository(Database::connect()))->metadataFields($type, $lang);

    $response->getBody()->write(json_encode([
        'lang' => $lang,
        'type' => $type,
        'data' => $fields,
    ], JSON_THROW_ON_ERROR));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/filters', function (Request $request, Response $response): Response {
    $query = $request->getQueryParams();
    $lang = (string) ($query['lang'] ?? 'en');
    $type = isset($query['type']) ? trim((string) $query['type']) : null;

    $filters = (new ProductRepository(Database::connect()))->metadataFilters($type, $lang);

    $response->getBody()->write(json_encode([
        'lang' => $lang,
        'type' => $type,
        'data' => $filters,
    ], JSON_THROW_ON_ERROR));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/reindex', function (Request $request, Response $response): Response {
    $repository = new ProductRepository(Database::connect());
    $products = $repository->allForIndexing();

    $task = (new SearchService())->reindexProducts($products);

    $response->getBody()->write(json_encode([
        'message' => 'Reindex requested',
        'products_count' => count($products),
        'meilisearch_task' => $task,
    ], JSON_THROW_ON_ERROR));

    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/search', function (Request $request, Response $response): Response {
    $query = trim((string) ($request->getQueryParams()['q'] ?? ''));
    $type = isset($request->getQueryParams()['type'])
        ? trim((string) $request->getQueryParams()['type'])
        : null;

    if ($query === '') {
        $response->getBody()->write(json_encode([
            'error' => 'Query parameter q is required',
        ], JSON_THROW_ON_ERROR));

        return $response
            ->withStatus(422)
            ->withHeader('Content-Type', 'application/json');
    }

    $result = (new SearchService())->searchProducts($query, $type);

    $response->getBody()->write(json_encode($result, JSON_THROW_ON_ERROR));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
