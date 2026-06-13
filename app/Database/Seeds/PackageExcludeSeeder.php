<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackageExcludeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['package_id' => 1, 'package_exclude_type_id' => 2, 'sort_order' => 1, 'status' => 1],
            ['package_id' => 1, 'package_exclude_type_id' => 5, 'sort_order' => 2, 'status' => 1],
            ['package_id' => 2, 'package_exclude_type_id' => 1, 'sort_order' => 1, 'status' => 1],
            ['package_id' => 2, 'package_exclude_type_id' => 5, 'sort_order' => 2, 'status' => 1],
            ['package_id' => 2, 'package_exclude_type_id' => 6, 'sort_order' => 3, 'status' => 1],
            ['package_id' => 3, 'package_exclude_type_id' => 1, 'sort_order' => 1, 'status' => 1],
            ['package_id' => 3, 'package_exclude_type_id' => 6, 'sort_order' => 2, 'status' => 1],
        ];

        $this->db->table('t_package_excludes')->insertBatch($data);
    }
}
