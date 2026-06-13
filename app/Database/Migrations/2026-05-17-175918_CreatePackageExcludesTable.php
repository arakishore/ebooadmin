<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePackageExcludesTable extends Migration
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
            'package_exclude_type_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
            ],
            'sort_order' => [
                'type' => 'INT',
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
        $this->forge->addKey('package_exclude_type_id');
        $this->forge->addForeignKey('package_id', 't_packages', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('package_exclude_type_id', 'mst_package_exclude_types', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('t_package_excludes');
    }

    public function down()
    {
        $this->forge->dropTable('t_package_excludes', true);
    }
}
