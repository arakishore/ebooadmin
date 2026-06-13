<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePartnersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'website_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'sort_order' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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
        $this->forge->addKey('status');
        $this->forge->addKey('sort_order');
        $this->forge->createTable('mst_partners');
    }

    public function down()
    {
        $this->forge->dropTable('mst_partners', true);
    }
}
