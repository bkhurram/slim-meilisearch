<?php

declare(strict_types=1);

namespace App\Handler;

use App\Domain\ProductType;
use App\Handler\Contracts\JsonResponder;
use App\Service\ProductService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class MetadataFieldsHandler
{
    use JsonResponder;

    public function __construct(private readonly ProductService $productService)
    {
    }

    /**
     * @throws \JsonException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $query = $request->getQueryParams();
        $lang = $request->getAttribute('locale');
        $type = ProductType::normalize(isset($query['type']) ? (string) $query['type'] : null);

        return $this->json($response, [
            'type' => $type,
            'data' => $this->productService->listMetadataFields($lang, $type),
        ]);
    }
}
