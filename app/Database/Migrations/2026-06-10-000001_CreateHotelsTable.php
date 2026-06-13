<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHotelsTable extends Migration
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
                'constraint' => 180,
            ],
            'hotel_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
            ],
            'hotel_category_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
            ],
            'country_id' => [
                'type'     => 'MEDIUMINT ',
                'unsigned' => true,
            ],
            'state_id' => [
                'type'     => 'MEDIUMINT ',
                'unsigned' => true,
            ],
            'city_id' => [
                'type'     => 'MEDIUMINT ',
                'unsigned' => true,
            ],
            'address' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'sort_order' => [
                'type'    => 'INT',
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
        $this->forge->addKey('hotel_category_id');
        $this->forge->addKey('country_id');
        $this->forge->addKey('state_id');
        $this->forge->addKey('city_id');
        $this->forge->addKey('hotel_code');

        $this->forge->addForeignKey('hotel_category_id', 'mst_hotel_categories', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('mst_hotels');

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
            'hotel_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
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
        $this->forge->addKey('package_id');
        $this->forge->addKey('hotel_id');
        $this->forge->addUniqueKey(['package_id', 'hotel_id']);
        $this->forge->addForeignKey('package_id', 't_packages', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('hotel_id', 'mst_hotels', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('t_package_hotels');
    }

    public function down()
    {
        $this->forge->dropTable('t_package_hotels', true);
        $this->forge->dropTable('mst_hotels', true);
    }
}
