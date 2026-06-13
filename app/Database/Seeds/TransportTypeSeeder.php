<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransportTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Flight', 'slug' => 'flight', 'status' => 1],
            ['name' => 'Private Cab', 'slug' => 'private-cab', 'status' => 1],
            ['name' => 'Shared Coach', 'slug' => 'shared-coach', 'status' => 1],
            ['name' => 'Cruise', 'slug' => 'cruise', 'status' => 1],
            ['name' => 'Train', 'slug' => 'train', 'status' => 1],
        ];

        $this->db->table('mst_transport_types')->insertBatch($data);
    }
}