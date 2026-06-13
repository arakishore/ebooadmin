<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDestinationImagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'destination_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'title' => [
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
        $this->forge->addKey('destination_id');
        $this->forge->addForeignKey('destination_id', 'mst_destinations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('t_destination_images');
    }

    public function down()
    {
        $this->forge->dropTable('t_destination_images', true);
    }
}
