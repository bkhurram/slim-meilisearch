<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\DatabaseConnectionFactory;
use App\Repository\ProductRepository;

final class ProductService
{
    public function __construct(private readonly DatabaseConnectionFactory $connection)
    {
    }

    /** @return array<int, array<string, mixed>> */
    public function listProducts(string $lang, ?string $type): array
    {
        return $this->repository()->all($lang, $type);
    }

    /** @return array<int, array<string, mixed>> */
    public function listMetadataFields(string $lang, ?string $type): array
    {
        return $this->repository()->metadataFields($type, $lang);
    }

    /** @return array<int, array<string, mixed>> */
    public function listMetadataFilters(string $lang, ?string $type): array
    {
        return $this->repository()->metadataFilters($type, $lang);
    }

    /** @return array<int, array<string, mixed>> */
    public function productsForIndexing(): array
    {
        return $this->repository()->allForIndexing();
    }

    private function repository(): ProductRepository
    {
        return new ProductRepository($this->connection->create());
    }
}
