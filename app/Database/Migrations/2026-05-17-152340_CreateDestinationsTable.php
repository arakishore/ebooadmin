<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDestinationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 150,
            ],
            'slug' => [
                'type' => 'VARCHAR',
                'constraint' => 180,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => true,
            ],

            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => true,
            ],

            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'banner_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'sort_order' => [
                'type' => 'INT',
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('mst_destinations');
    }

    public function down()
    {
        $this->forge->dropTable('mst_destinations', true);
    }
}
