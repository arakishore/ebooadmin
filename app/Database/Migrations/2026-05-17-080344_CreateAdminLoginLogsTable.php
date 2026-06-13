<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminLoginLogsTable extends Migration
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

            'admin_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],

            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
            ],

            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'login_status' => [
                'type'       => 'ENUM',
                'constraint' => ['success', 'failed'],
            ],

            'failure_reason' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'logged_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],

        ]);

        $this->forge->addKey('id', true);

        $this->forge->addKey('admin_id');

        $this->forge->addForeignKey(
            'admin_id',
            'admins',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->forge->createTable('admin_login_logs');
    }

    public function down()
    {
        $this->forge->dropTable('admin_login_logs', true);
    }
}