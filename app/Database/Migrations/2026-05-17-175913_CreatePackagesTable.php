<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePackagesTable extends Migration
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
            'package_category_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
            ],
            'hotel_category_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
            ],
            'meal_plan_type_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
            ],
            'transport_type_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'short_description' => [
                'type' => 'TEXT',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'duration_days' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'duration_nights' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'starting_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'sale_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'default'    => 0.00,
            ],
            'featured_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'banner_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'map_image_code' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'is_featured' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'meta_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'meta_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'meta_keywords' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->addKey('destination_id');
        $this->forge->addKey('package_category_id');
        $this->forge->addKey('hotel_category_id');
        $this->forge->addKey('meal_plan_type_id');
        $this->forge->addKey('transport_type_id');
        $this->forge->addUniqueKey('slug');

        $this->forge->addForeignKey('destination_id', 'mst_destinations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('package_category_id', 'mst_package_categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('hotel_category_id', 'mst_hotel_categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('meal_plan_type_id', 'mst_meal_plan_types', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('transport_type_id', 'mst_transport_types', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('t_packages');
    }

    public function down()
    {
        $this->forge->dropTable('t_packages', true);
    }
}
