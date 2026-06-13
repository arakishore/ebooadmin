<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMealPlanTypesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 180,
            ],

            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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

        $this->forge->addUniqueKey('slug');

        $this->forge->createTable('mst_meal_plan_types');
    }

    public function down()
    {
        $this->forge->dropTable('mst_meal_plan_types', true);
    }
}