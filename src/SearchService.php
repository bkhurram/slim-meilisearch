<?php

declare(strict_types=1);

namespace App;

use Meilisearch\Client;

final class SearchService
{
    private Client $client;

    public function __construct()
    {
        $host = Config::get('MEILI_HOST', 'http://meilisearch:7700');
        $masterKey = Config::get('MEILI_MASTER_KEY', 'masterKey123');
        $this->client = new Client($host, $masterKey);
    }

    public function reindexProducts(array $products): array
    {
        $index = $this->client->index('products');

        $index->updateFilterableAttributes(['product_type']);
        $index->updateSortableAttributes(['price']);
        $index->updateSearchableAttributes([
            'sku',
            'product_type',
            'name',
            'description',
            'metadata',
            'searchable_text',
        ]);

        return $index->addDocuments($products, 'id');
    }

    public function searchProducts(string $query, ?string $type = null): array
    {
        $index = $this->client->index('products');

        $options = [
            'attributesToHighlight' => ['name.en', 'name.it', 'description.en', 'description.it'],
            'limit' => 20,
        ];

        if ($type !== null && $type !== '') {
            $escaped = str_replace('"', '\\"', $type);
            $options['filter'] = sprintf('product_type = "%s"', $escaped);
        }

        return $index->search($query, $options)->toArray();
    }
}
