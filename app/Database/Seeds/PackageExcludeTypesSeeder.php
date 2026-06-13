<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackageExcludeTypesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'International Flights', 'slug' => 'international-flights', 'status' => 1],
            ['name' => 'Travel Insurance', 'slug' => 'travel-insurance', 'status' => 1],
            ['name' => 'Visa Fees', 'slug' => 'visa-fees', 'status' => 1],
            ['name' => 'Personal Expenses', 'slug' => 'personal-expenses', 'status' => 1],
            ['name' => 'Optional Activities', 'slug' => 'optional-activities', 'status' => 1],
            ['name' => 'Room Service', 'slug' => 'room-service', 'status' => 1],
        ];

        $this->db->table('mst_package_exclude_types')->insertBatch($data);
    }
}
