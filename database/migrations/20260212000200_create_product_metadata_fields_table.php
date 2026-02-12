<?php

declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class CreateProductMetadataFieldsTable extends AbstractMigration
{
    public function up(): void
    {
        if ($this->hasTable('product_metadata_fields')) {
            return;
        }

        $this->table('product_metadata_fields')
            ->addColumn('product_type', 'string', ['limit' => 50])
            ->addColumn('field_key', 'string', ['limit' => 100])
            ->addColumn('label', 'json')
            ->addColumn('value_type', 'string', ['limit' => 30, 'default' => 'text'])
            ->addColumn('is_required', 'boolean', ['default' => false])
            ->addColumn('sort_order', 'integer', ['default' => 0, 'limit' => MysqlAdapter::INT_REGULAR])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'null' => false,
            ])
            ->addIndex(['product_type', 'field_key'], ['unique' => true, 'name' => 'ux_type_field'])
            ->create();
    }

    public function down(): void
    {
        if (!$this->hasTable('product_metadata_fields')) {
            return;
        }

        $this->table('product_metadata_fields')->drop()->save();
    }
}
