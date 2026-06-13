<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackageIncludeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['package_id' => 1, 'package_include_type_id' => 1, 'sort_order' => 1, 'status' => 1],
            ['package_id' => 1, 'package_include_type_id' => 2, 'sort_order' => 2, 'status' => 1],
            ['package_id' => 1, 'package_include_type_id' => 3, 'sort_order' => 3, 'status' => 1],
            ['package_id' => 1, 'package_include_type_id' => 4, 'sort_order' => 4, 'status' => 1],
            ['package_id' => 1, 'package_include_type_id' => 5, 'sort_order' => 5, 'status' => 1],
            ['package_id' => 1, 'package_include_type_id' => 6, 'sort_order' => 6, 'status' => 1],
            ['package_id' => 2, 'package_include_type_id' => 1, 'sort_order' => 1, 'status' => 1],
            ['package_id' => 2, 'package_include_type_id' => 2, 'sort_order' => 2, 'status' => 1],
            ['package_id' => 2, 'package_include_type_id' => 3, 'sort_order' => 3, 'status' => 1],
            ['package_id' => 2, 'package_include_type_id' => 4, 'sort_order' => 4, 'status' => 1],
            ['package_id' => 3, 'package_include_type_id' => 1, 'sort_order' => 1, 'status' => 1],
            ['package_id' => 3, 'package_include_type_id' => 2, 'sort_order' => 2, 'status' => 1],
            ['package_id' => 3, 'package_include_type_id' => 3, 'sort_order' => 3, 'status' => 1],
            ['package_id' => 3, 'package_include_type_id' => 5, 'sort_order' => 4, 'status' => 1],
        ];

        $this->db->table('t_package_includes')->insertBatch($data);
    }
}
