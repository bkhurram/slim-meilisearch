<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateProductsTable extends AbstractMigration
{
    public function up(): void
    {
        if ($this->hasTable('products')) {
            return;
        }

        $this->table('products')
            ->addColumn('sku', 'string', ['limit' => 64])
            ->addColumn('product_type', 'string', ['limit' => 50])
            ->addColumn('name', 'json')
            ->addColumn('description', 'json', ['null' => true])
            ->addColumn('metadata', 'json', ['null' => true])
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'null'    => false,
            ])
            ->addIndex(['sku'], ['unique' => true])
            ->create();
    }

    public function down(): void
    {
        if (!$this->hasTable('products')) {
            return;
        }

        $this->table('products')->drop()->save();
    }
}
