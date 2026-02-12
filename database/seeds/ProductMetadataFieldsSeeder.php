<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

final class ProductMetadataFieldsSeeder extends AbstractSeed
{
    public function run(): void
    {
        $this->execute('TRUNCATE TABLE product_metadata_fields');

        foreach ($this->records() as $record) {
            $this->table('slim_demo.product_metadata_fields')->insert($record)->saveData();
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function records(): array
    {
        return [
            ['product_type' => 'electronics', 'field_key' => 'brand', 'label' => json_encode(['en' => 'Brand', 'it' => 'Marca'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 10],
            ['product_type' => 'electronics', 'field_key' => 'made_in', 'label' => json_encode(['en' => 'Made In', 'it' => 'Prodotto in'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 20],
            ['product_type' => 'electronics', 'field_key' => 'color', 'label' => json_encode(['en' => 'Color', 'it' => 'Colore'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 30],
            ['product_type' => 'electronics', 'field_key' => 'material', 'label' => json_encode(['en' => 'Material', 'it' => 'Materiale'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 40],
            ['product_type' => 'electronics', 'field_key' => 'height', 'label' => json_encode(['en' => 'Height', 'it' => 'Altezza'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 50],
            ['product_type' => 'electronics', 'field_key' => 'width', 'label' => json_encode(['en' => 'Width', 'it' => 'Larghezza'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 60],
            ['product_type' => 'electronics', 'field_key' => 'depth', 'label' => json_encode(['en' => 'Depth', 'it' => 'Profondita'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 70],
            ['product_type' => 'electronics', 'field_key' => 'weight', 'label' => json_encode(['en' => 'Weight', 'it' => 'Peso'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 80],
            ['product_type' => 'electronics', 'field_key' => 'screen_size', 'label' => json_encode(['en' => 'Screen Size', 'it' => 'Dimensione Schermo'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 90],
            ['product_type' => 'electronics', 'field_key' => 'os', 'label' => json_encode(['en' => 'Operating System', 'it' => 'Sistema Operativo'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 100],
            ['product_type' => 'electronics', 'field_key' => 'cpu', 'label' => json_encode(['en' => 'CPU', 'it' => 'CPU'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 110],
            ['product_type' => 'electronics', 'field_key' => 'ram', 'label' => json_encode(['en' => 'RAM', 'it' => 'RAM'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 120],
            ['product_type' => 'electronics', 'field_key' => 'storage', 'label' => json_encode(['en' => 'Storage', 'it' => 'Archiviazione'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 130],
            ['product_type' => 'electronics', 'field_key' => 'coating', 'label' => json_encode(['en' => 'Coating', 'it' => 'Rivestimento'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 140],

            ['product_type' => 'accessory', 'field_key' => 'brand', 'label' => json_encode(['en' => 'Brand', 'it' => 'Marca'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 10],
            ['product_type' => 'accessory', 'field_key' => 'made_in', 'label' => json_encode(['en' => 'Made In', 'it' => 'Prodotto in'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 20],
            ['product_type' => 'accessory', 'field_key' => 'color', 'label' => json_encode(['en' => 'Color', 'it' => 'Colore'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 30],
            ['product_type' => 'accessory', 'field_key' => 'material', 'label' => json_encode(['en' => 'Material', 'it' => 'Materiale'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 40],
            ['product_type' => 'accessory', 'field_key' => 'height', 'label' => json_encode(['en' => 'Height', 'it' => 'Altezza'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 50],
            ['product_type' => 'accessory', 'field_key' => 'width', 'label' => json_encode(['en' => 'Width', 'it' => 'Larghezza'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 60],
            ['product_type' => 'accessory', 'field_key' => 'depth', 'label' => json_encode(['en' => 'Depth', 'it' => 'Profondita'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 70],
            ['product_type' => 'accessory', 'field_key' => 'layout', 'label' => json_encode(['en' => 'Layout', 'it' => 'Layout'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 80],
            ['product_type' => 'accessory', 'field_key' => 'switch_type', 'label' => json_encode(['en' => 'Switch Type', 'it' => 'Tipo di Switch'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 90],
            ['product_type' => 'accessory', 'field_key' => 'connectivity', 'label' => json_encode(['en' => 'Connectivity', 'it' => 'Connettivita'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 100],
            ['product_type' => 'accessory', 'field_key' => 'dpi', 'label' => json_encode(['en' => 'DPI', 'it' => 'DPI'], JSON_THROW_ON_ERROR), 'value_type' => 'number', 'is_required' => 0, 'sort_order' => 110],
            ['product_type' => 'accessory', 'field_key' => 'weight', 'label' => json_encode(['en' => 'Weight', 'it' => 'Peso'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 120],
            ['product_type' => 'accessory', 'field_key' => 'coating', 'label' => json_encode(['en' => 'Coating', 'it' => 'Rivestimento'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 130],

            ['product_type' => 'apparel', 'field_key' => 'brand', 'label' => json_encode(['en' => 'Brand', 'it' => 'Marca'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 10],
            ['product_type' => 'apparel', 'field_key' => 'made_in', 'label' => json_encode(['en' => 'Made In', 'it' => 'Prodotto in'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 20],
            ['product_type' => 'apparel', 'field_key' => 'color', 'label' => json_encode(['en' => 'Color', 'it' => 'Colore'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 30],
            ['product_type' => 'apparel', 'field_key' => 'material', 'label' => json_encode(['en' => 'Material', 'it' => 'Materiale'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 40],
            ['product_type' => 'apparel', 'field_key' => 'size', 'label' => json_encode(['en' => 'Size', 'it' => 'Taglia'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 50],
            ['product_type' => 'apparel', 'field_key' => 'fit', 'label' => json_encode(['en' => 'Fit', 'it' => 'Vestibilita'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 60],
            ['product_type' => 'apparel', 'field_key' => 'height', 'label' => json_encode(['en' => 'Height', 'it' => 'Altezza'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 70],
            ['product_type' => 'apparel', 'field_key' => 'width', 'label' => json_encode(['en' => 'Width', 'it' => 'Larghezza'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 80],
            ['product_type' => 'apparel', 'field_key' => 'depth', 'label' => json_encode(['en' => 'Depth', 'it' => 'Profondita'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 90],
            ['product_type' => 'apparel', 'field_key' => 'closure_type', 'label' => json_encode(['en' => 'Closure Type', 'it' => 'Tipo di Chiusura'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 100],
            ['product_type' => 'apparel', 'field_key' => 'strap_type', 'label' => json_encode(['en' => 'Strap Type', 'it' => 'Tipo di Spalline'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 110],
            ['product_type' => 'apparel', 'field_key' => 'coating', 'label' => json_encode(['en' => 'Coating', 'it' => 'Rivestimento'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 120],

            ['product_type' => 'home', 'field_key' => 'brand', 'label' => json_encode(['en' => 'Brand', 'it' => 'Marca'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 10],
            ['product_type' => 'home', 'field_key' => 'made_in', 'label' => json_encode(['en' => 'Made In', 'it' => 'Prodotto in'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 20],
            ['product_type' => 'home', 'field_key' => 'color', 'label' => json_encode(['en' => 'Color', 'it' => 'Colore'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 30],
            ['product_type' => 'home', 'field_key' => 'material', 'label' => json_encode(['en' => 'Material', 'it' => 'Materiale'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 40],
            ['product_type' => 'home', 'field_key' => 'height', 'label' => json_encode(['en' => 'Height', 'it' => 'Altezza'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 50],
            ['product_type' => 'home', 'field_key' => 'width', 'label' => json_encode(['en' => 'Width', 'it' => 'Larghezza'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 60],
            ['product_type' => 'home', 'field_key' => 'depth', 'label' => json_encode(['en' => 'Depth', 'it' => 'Profondita'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 70],
            ['product_type' => 'home', 'field_key' => 'capacity', 'label' => json_encode(['en' => 'Capacity', 'it' => 'Capacita'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 80],
            ['product_type' => 'home', 'field_key' => 'weight', 'label' => json_encode(['en' => 'Weight', 'it' => 'Peso'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 90],
            ['product_type' => 'home', 'field_key' => 'closure_type', 'label' => json_encode(['en' => 'Closure Type', 'it' => 'Tipo di Chiusura'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 100],
            ['product_type' => 'home', 'field_key' => 'coating', 'label' => json_encode(['en' => 'Coating', 'it' => 'Rivestimento'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 110],

            ['product_type' => 'footwear', 'field_key' => 'brand', 'label' => json_encode(['en' => 'Brand', 'it' => 'Marca'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 10],
            ['product_type' => 'footwear', 'field_key' => 'made_in', 'label' => json_encode(['en' => 'Made In', 'it' => 'Prodotto in'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 20],
            ['product_type' => 'footwear', 'field_key' => 'color', 'label' => json_encode(['en' => 'Color', 'it' => 'Colore'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 30],
            ['product_type' => 'footwear', 'field_key' => 'material', 'label' => json_encode(['en' => 'Material', 'it' => 'Materiale'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 40],
            ['product_type' => 'footwear', 'field_key' => 'size', 'label' => json_encode(['en' => 'Size', 'it' => 'Taglia'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 1, 'sort_order' => 50],
            ['product_type' => 'footwear', 'field_key' => 'height', 'label' => json_encode(['en' => 'Height', 'it' => 'Altezza'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 60],
            ['product_type' => 'footwear', 'field_key' => 'width', 'label' => json_encode(['en' => 'Width', 'it' => 'Larghezza'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 70],
            ['product_type' => 'footwear', 'field_key' => 'depth', 'label' => json_encode(['en' => 'Depth', 'it' => 'Profondita'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 80],
            ['product_type' => 'footwear', 'field_key' => 'weight', 'label' => json_encode(['en' => 'Weight', 'it' => 'Peso'], JSON_THROW_ON_ERROR), 'value_type' => 'dimension', 'is_required' => 0, 'sort_order' => 90],
            ['product_type' => 'footwear', 'field_key' => 'closure_type', 'label' => json_encode(['en' => 'Closure Type', 'it' => 'Tipo di Chiusura'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 100],
            ['product_type' => 'footwear', 'field_key' => 'strap_type', 'label' => json_encode(['en' => 'Strap Type', 'it' => 'Tipo di Spalline'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 110],
            ['product_type' => 'footwear', 'field_key' => 'coating', 'label' => json_encode(['en' => 'Coating', 'it' => 'Rivestimento'], JSON_THROW_ON_ERROR), 'value_type' => 'text', 'is_required' => 0, 'sort_order' => 120],
        ];
    }
}
