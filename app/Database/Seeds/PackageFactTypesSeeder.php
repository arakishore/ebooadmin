<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackageFactTypesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Duration', 'slug' => 'duration', 'status' => 1],
            ['name' => 'Maximum Group Size', 'slug' => 'maximum-group-size', 'status' => 1],
            ['name' => 'Tour Difficulty', 'slug' => 'tour-difficulty', 'status' => 1],
            ['name' => 'Best Season', 'slug' => 'best-season', 'status' => 1],
            ['name' => 'Starting Price', 'slug' => 'starting-price', 'status' => 1],
            ['name' => 'Verified Guide', 'slug' => 'verified-guide', 'status' => 1],
        ];

        $this->db->table('mst_package_fact_types')->insertBatch($data);
    }
}
