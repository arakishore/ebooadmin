<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ActivityTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Adventure', 'slug' => 'adventure', 'status' => 1],
            ['name' => 'Water Sports', 'slug' => 'water-sports', 'status' => 1],
            ['name' => 'Sightseeing', 'slug' => 'sightseeing', 'status' => 1],
            ['name' => 'Safari', 'slug' => 'safari', 'status' => 1],
            ['name' => 'Cruise', 'slug' => 'cruise', 'status' => 1],
            ['name' => 'Trekking', 'slug' => 'trekking', 'status' => 1],
            ['name' => 'Nightlife', 'slug' => 'nightlife', 'status' => 1],
        ];

        $this->db->table('mst_activity_types')->insertBatch($data);
    }
}