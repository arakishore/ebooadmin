<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePackageCategoryRelationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'package_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
            ],
            'category_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('package_id');
        $this->forge->addKey('category_id');
        $this->forge->addForeignKey('package_id', 't_packages', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'mst_package_categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('t_package_category_relations');
    }

    public function down()
    {
        $this->forge->dropTable('t_package_category_relations', true);
    }
}
