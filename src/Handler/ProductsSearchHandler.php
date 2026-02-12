<?php

declare(strict_types=1);

namespace App\Handler;

use App\Domain\ProductType;
use App\Handler\Contracts\JsonResponder;
use App\Service\SearchService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ProductsSearchHandler
{
    use JsonResponder;

    public function __construct(private readonly SearchService $searchService)
    {
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $queryParams = $request->getQueryParams();
        $query = trim((string) ($queryParams['q'] ?? ''));

        $id = isset($queryParams['id']) ? (string) $queryParams['id'] : null;
        $type = ProductType::normalize(isset($queryParams['type']) ? (string) $queryParams['type'] : null);

        if ($query === '') {
            return $this->json($response, ['error' => 'Query parameter q is required'], 422);
        }

        $result = $this->searchService->searchProducts($query, $id, $type);
        return $this->json($response, $result);
    }
}
