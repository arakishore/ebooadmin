<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackageCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'   => 'Honeymoon',
                'slug'   => 'honeymoon',
                'status' => 1,
            ],
            [
                'name'   => 'Family',
                'slug'   => 'family',
                'status' => 1,
            ],
            [
                'name'   => 'Adventure',
                'slug'   => 'adventure',
                'status' => 1,
            ],
            [
                'name'   => 'Luxury',
                'slug'   => 'luxury',
                'status' => 1,
            ],
            [
                'name'   => 'Group Tour',
                'slug'   => 'group-tour',
                'status' => 1,
            ],
        ];

        $this->db->table('mst_package_categories')->insertBatch($data);
    }
}