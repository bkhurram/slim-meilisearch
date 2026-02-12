<?php

declare(strict_types=1);

namespace App\Handler;

use App\Handler\Contracts\JsonResponder;
use App\Service\ProductService;
use App\Service\SearchService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ProductsReindexHandler
{
    use JsonResponder;

    public function __construct(
        private readonly ProductService $productService,
        private readonly SearchService $searchService
    ) {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $products = $this->productService->productsForIndexing();
        $task = $this->searchService->reindexProducts($products);

        return $this->json($response, [
            'message'          => 'Reindex requested',
            'products_count'   => count($products),
            'meilisearch_task' => $task,
        ]);
    }
}
