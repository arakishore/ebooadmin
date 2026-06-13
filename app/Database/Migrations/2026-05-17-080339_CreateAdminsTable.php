<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdminsTable extends Migration
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

            'role_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'mobile' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],

            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'profile_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],

            'last_login_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'last_login_ip' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
            ],

            'email_verified_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'password_changed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'remember_token' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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

        $this->forge->addUniqueKey('email');

        $this->forge->addKey('role_id');

        $this->forge->addForeignKey(
            'role_id',
            'admin_roles',
            'id',
            'CASCADE',
            'RESTRICT'
        );

        $this->forge->createTable('admins');
    }

    public function down()
    {
        $this->forge->dropTable('admins', true);
    }
}