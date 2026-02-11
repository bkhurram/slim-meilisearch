<?php

declare(strict_types=1);

namespace App\Service;

use Meilisearch\Client;

final class SearchService
{
    private Client $client;

    /** @param array<string, mixed> $meiliConfig */
    public function __construct(array $meiliConfig)
    {
        $host = (string) ($meiliConfig['host'] ?? 'http://meilisearch:7700');
        $masterKey = (string) ($meiliConfig['master_key'] ?? 'masterKey123');
        $this->client = new Client($host, $masterKey);
    }

    /** @param array<int, array<string, mixed>> $products */
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
        $index->updateSynonyms([
            'laptop' => ['portatile', 'notebook'],
            'portatile' => ['laptop', 'notebook'],
            'notebook' => ['laptop', 'portatile'],
            'ceramica' => ['terracotta', 'porcellana'],
            'terracotta' => ['ceramica', 'porcellana'],
            'porcellana' => ['ceramica', 'terracotta'],
            'idrorepellente' => ['impermeabile', 'resistente all acqua', 'water-resistant'],
            'impermeabile' => ['idrorepellente', 'resistente all acqua', 'water-resistant'],
            'resistente all acqua' => ['idrorepellente', 'impermeabile', 'water-resistant'],
            'water-resistant' => ['idrorepellente', 'impermeabile', 'resistente all acqua'],
            'stringhe' => ['lacci', 'stringacci', 'cordoncini'],
            'lacci' => ['stringhe', 'stringacci', 'cordoncini'],
            'stringacci' => ['stringhe', 'lacci', 'cordoncini'],
            'cordoncini' => ['stringhe', 'lacci', 'stringacci'],
            'ubuntu' => ['linux', 'open-source'],
            'linux' => ['ubuntu', 'open-source'],
            'open-source' => ['ubuntu', 'linux'],
            'aderente' => ['slim', 'attillata', 'fitted'],
            'slim' => ['aderente', 'attillata', 'fitted'],
            'attillata' => ['aderente', 'slim', 'fitted'],
            'fitted' => ['aderente', 'slim', 'attillata'],
            'zip' => ['cerniera', 'lampo'],
            'cerniera' => ['zip', 'lampo'],
            'lampo' => ['zip', 'cerniera'],
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
