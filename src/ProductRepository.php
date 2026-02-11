<?php

declare(strict_types=1);

namespace App;

use PDO;

final class ProductRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(string $lang = 'en', ?string $type = null): array
    {
        $safeLang = $this->sanitizeLang($lang);

        $sql = "
            SELECT
                id,
                sku,
                product_type,
                price,
                JSON_UNQUOTE(COALESCE(JSON_EXTRACT(name, '$.$safeLang'), JSON_EXTRACT(name, '$.en'))) AS name,
                JSON_UNQUOTE(COALESCE(JSON_EXTRACT(description, '$.$safeLang'), JSON_EXTRACT(description, '$.en'))) AS description,
                CAST(metadata AS CHAR) AS metadata_json,
                CAST(name AS CHAR) AS name_translations_json,
                CAST(description AS CHAR) AS description_translations_json
            FROM products
        ";

        if ($type !== null && $type !== '') {
            $sql .= ' WHERE product_type = :type';
        }

        $sql .= ' ORDER BY id ASC';

        $stmt = $this->pdo->prepare($sql);

        if ($type !== null && $type !== '') {
            $stmt->bindValue(':type', $type);
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();

        return array_map(function (array $row) use ($safeLang): array {
            $metadataTranslations = $this->decodeJson($row['metadata_json'] ?? '{}');
            $row['metadata'] = $this->localizeMetadata($metadataTranslations, $safeLang);
            $row['metadata_translations'] = $metadataTranslations;
            $row['name_translations'] = $this->decodeJson($row['name_translations_json'] ?? '{}');
            $row['description_translations'] = $this->decodeJson($row['description_translations_json'] ?? '{}');
            unset($row['metadata_json'], $row['name_translations_json'], $row['description_translations_json']);

            return $row;
        }, $rows);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function allForIndexing(): array
    {
        $stmt = $this->pdo->query(
            'SELECT id, sku, product_type, price, CAST(name AS CHAR) AS name_json, CAST(description AS CHAR) AS description_json, CAST(metadata AS CHAR) AS metadata_json FROM products ORDER BY id ASC'
        );

        $rows = $stmt->fetchAll();

        return array_map(function (array $row): array {
            $name = $this->decodeJson($row['name_json'] ?? '{}');
            $description = $this->decodeJson($row['description_json'] ?? '{}');
            $metadata = $this->decodeJson($row['metadata_json'] ?? '{}');

            return [
                'id' => (int) $row['id'],
                'sku' => $row['sku'],
                'product_type' => $row['product_type'],
                'price' => (float) $row['price'],
                'name' => $name,
                'description' => $description,
                'metadata' => $metadata,
                'searchable_text' => $this->buildSearchableText($name, $description, $metadata),
            ];
        }, $rows);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function metadataFields(?string $type = null, string $lang = 'en'): array
    {
        $safeLang = $this->sanitizeLang($lang);

        $sql = '
            SELECT
                product_type,
                field_key,
                value_type,
                is_required,
                sort_order,
                CAST(label AS CHAR) AS label_json
            FROM product_metadata_fields
        ';

        if ($type !== null && $type !== '') {
            $sql .= ' WHERE product_type = :type';
        }

        $sql .= ' ORDER BY product_type ASC, sort_order ASC, field_key ASC';

        $stmt = $this->pdo->prepare($sql);

        if ($type !== null && $type !== '') {
            $stmt->bindValue(':type', $type);
        }

        $stmt->execute();
        $rows = $stmt->fetchAll();

        return array_map(function (array $row) use ($safeLang): array {
            $labelTranslations = $this->decodeJson($row['label_json'] ?? '{}');
            $label = $this->extractLocalizedValue($labelTranslations, $safeLang);

            return [
                'product_type' => $row['product_type'],
                'field_key' => $row['field_key'],
                'value_type' => $row['value_type'],
                'is_required' => (bool) $row['is_required'],
                'sort_order' => (int) $row['sort_order'],
                'label' => $label,
                'label_translations' => $labelTranslations,
            ];
        }, $rows);
    }

    private function sanitizeLang(string $lang): string
    {
        $lang = strtolower(trim($lang));

        if (preg_match('/^[a-z]{2}$/', $lang) !== 1) {
            return 'en';
        }

        return $lang;
    }

    /**
     * @return array<string, mixed>
     */
    private function decodeJson(string $json): array
    {
        $decoded = json_decode($json, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @param array<string, mixed> $name
     * @param array<string, mixed> $description
     * @param array<string, mixed> $metadata
     */
    private function buildSearchableText(array $name, array $description, array $metadata): string
    {
        $parts = [];
        $this->collectScalars([$name, $description, $metadata], $parts);
        return implode(' ', $parts);
    }

    /**
     * @param array<string, mixed> $metadata
     * @return array<string, mixed>
     */
    private function localizeMetadata(array $metadata, string $lang): array
    {
        $localized = [];

        foreach ($metadata as $key => $value) {
            if (is_array($value)) {
                $localized[$key] = $this->extractLocalizedValue($value, $lang);
                continue;
            }

            $localized[$key] = $value;
        }

        return $localized;
    }

    /**
     * @param array<string, mixed> $value
     * @return mixed
     */
    private function extractLocalizedValue(array $value, string $lang): mixed
    {
        if (array_key_exists($lang, $value) && !is_array($value[$lang])) {
            return $value[$lang];
        }

        if (array_key_exists('en', $value) && !is_array($value['en'])) {
            return $value['en'];
        }

        foreach ($value as $item) {
            if (!is_array($item)) {
                return $item;
            }
        }

        return $value;
    }

    /**
     * @param mixed $value
     * @param array<int, string> $parts
     */
    private function collectScalars(mixed $value, array &$parts): void
    {
        if (is_scalar($value)) {
            $parts[] = (string) $value;
            return;
        }

        if (!is_array($value)) {
            return;
        }

        foreach ($value as $item) {
            $this->collectScalars($item, $parts);
        }
    }
}
