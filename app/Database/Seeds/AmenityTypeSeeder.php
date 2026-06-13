<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AmenityTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Free WiFi', 'slug' => 'free-wifi', 'status' => 1],
            ['name' => 'Swimming Pool', 'slug' => 'swimming-pool', 'status' => 1],
            ['name' => 'Breakfast Included', 'slug' => 'breakfast-included', 'status' => 1],
            ['name' => 'Airport Transfer', 'slug' => 'airport-transfer', 'status' => 1],
            ['name' => 'Parking', 'slug' => 'parking', 'status' => 1],
            ['name' => 'Gym', 'slug' => 'gym', 'status' => 1],
            ['name' => 'Spa', 'slug' => 'spa', 'status' => 1],
        ];

        $this->db->table('mst_amenity_types')->insertBatch($data);
    }
}