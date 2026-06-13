<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        /*
        |--------------------------------------------------------------------------
        | Insert Super Admin Role
        |--------------------------------------------------------------------------
        */

        $this->db->table('admin_roles')->insert([

            'name'        => 'Super Admin',
            'slug'        => 'super-admin',
            'description' => 'Full access to admin panel',

            'status'      => 1,

            'created_at'  => $now,
            'updated_at'  => $now,

        ]);

        $roleId = $this->db->insertID();

        /*
        |--------------------------------------------------------------------------
        | Insert Default Admin User
        |--------------------------------------------------------------------------
        */

        $this->db->table('admins')->insert([

            'role_id' => $roleId,

            'name' => 'Administrator',

            'email' => 'admin@admin.com',

            'mobile' => '9999999999',

            'password' => password_hash('admin@1947.com', PASSWORD_DEFAULT),

            'status' => 1,

            'email_verified_at' => $now,
            'password_changed_at' => $now,

            'created_at' => $now,
            'updated_at' => $now,

        ]);
    }
}