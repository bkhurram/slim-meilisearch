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
        $query = trim((string) ($request->getQueryParams()['q'] ?? ''));
        $type = ProductType::normalize(isset($request->getQueryParams()['type']) ? (string) $request->getQueryParams()['type'] : null);

        if ($query === '') {
            return $this->json($response, ['error' => 'Query parameter q is required'], 422);
        }

        $result = $this->searchService->searchProducts($query, $type);
        $response->getBody()->write(json_encode($result, JSON_THROW_ON_ERROR));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
