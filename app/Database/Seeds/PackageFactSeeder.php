<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackageFactSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['package_id' => 1, 'package_fact_type_id' => 1, 'value' => '5 days', 'icon' => 'icon-calendar', 'sort_order' => 1, 'status' => 1],
            ['package_id' => 1, 'package_fact_type_id' => 2, 'value' => '20 guests', 'icon' => 'icon-users', 'sort_order' => 2, 'status' => 1],
            ['package_id' => 1, 'package_fact_type_id' => 3, 'value' => 'Easy', 'icon' => 'icon-star', 'sort_order' => 3, 'status' => 1],
            ['package_id' => 1, 'package_fact_type_id' => 4, 'value' => 'Winter to Spring', 'icon' => 'icon-sun', 'sort_order' => 4, 'status' => 1],
            ['package_id' => 1, 'package_fact_type_id' => 5, 'value' => '$2299', 'icon' => 'icon-tag', 'sort_order' => 5, 'status' => 1],
            ['package_id' => 1, 'package_fact_type_id' => 6, 'value' => 'English-speaking guide', 'icon' => 'icon-check', 'sort_order' => 6, 'status' => 1],
            ['package_id' => 2, 'package_fact_type_id' => 1, 'value' => '7 days', 'icon' => 'icon-calendar', 'sort_order' => 1, 'status' => 1],
            ['package_id' => 2, 'package_fact_type_id' => 2, 'value' => '25 guests', 'icon' => 'icon-users', 'sort_order' => 2, 'status' => 1],
            ['package_id' => 2, 'package_fact_type_id' => 3, 'value' => 'Moderate', 'icon' => 'icon-star', 'sort_order' => 3, 'status' => 1],
            ['package_id' => 2, 'package_fact_type_id' => 4, 'value' => 'November to March', 'icon' => 'icon-sun', 'sort_order' => 4, 'status' => 1],
            ['package_id' => 2, 'package_fact_type_id' => 5, 'value' => '$1399', 'icon' => 'icon-tag', 'sort_order' => 5, 'status' => 1],
            ['package_id' => 2, 'package_fact_type_id' => 6, 'value' => 'Family-friendly guide', 'icon' => 'icon-check', 'sort_order' => 6, 'status' => 1],
            ['package_id' => 3, 'package_fact_type_id' => 1, 'value' => '6 days', 'icon' => 'icon-calendar', 'sort_order' => 1, 'status' => 1],
            ['package_id' => 3, 'package_fact_type_id' => 2, 'value' => '15 guests', 'icon' => 'icon-users', 'sort_order' => 2, 'status' => 1],
            ['package_id' => 3, 'package_fact_type_id' => 3, 'value' => 'Active', 'icon' => 'icon-star', 'sort_order' => 3, 'status' => 1],
            ['package_id' => 3, 'package_fact_type_id' => 4, 'value' => 'April to October', 'icon' => 'icon-sun', 'sort_order' => 4, 'status' => 1],
            ['package_id' => 3, 'package_fact_type_id' => 5, 'value' => '$1099', 'icon' => 'icon-tag', 'sort_order' => 5, 'status' => 1],
            ['package_id' => 3, 'package_fact_type_id' => 6, 'value' => 'Professional local guide', 'icon' => 'icon-check', 'sort_order' => 6, 'status' => 1],
        ];

        $this->db->table('t_package_facts')->insertBatch($data);
    }
}
