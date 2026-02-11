<?php

declare(strict_types=1);

namespace App\Handler;

use App\Domain\ProductType;
use App\Handler\Contracts\JsonResponder;
use App\Service\ProductService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class ProductsFiltersHandler
{
    use JsonResponder;

    public function __construct(private readonly ProductService $productService)
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        $query = $request->getQueryParams();
        $lang = (string) ($query['lang'] ?? 'en');
        $type = ProductType::normalize(isset($query['type']) ? (string) $query['type'] : null);

        return $this->json($response, [
            'lang' => $lang,
            'type' => $type,
            'data' => $this->productService->listMetadataFilters($lang, $type),
        ]);
    }
}
