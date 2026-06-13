<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DestinationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'   => 'Kashmir',
                'slug'   => 'kashmir',
                'status' => 1,
            ],
            [
                'name'   => 'Goa',
                'slug'   => 'goa',
                'status' => 1,
            ],
            [
                'name'   => 'Kerala',
                'slug'   => 'kerala',
                'status' => 1,
            ],
            [
                'name'   => 'Rajasthan',
                'slug'   => 'rajasthan',
                'status' => 1,
            ],
            [
                'name'   => 'Leh Ladakh',
                'slug'   => 'leh-ladakh',
                'status' => 1,
            ],
            [
                'name'   => 'Himachal Pradesh',
                'slug'   => 'himachal-pradesh',
                'status' => 1,
            ],
            [
                'name'   => 'Andaman Islands',
                'slug'   => 'andaman-islands',
                'status' => 1,
            ],
            [
                'name'   => 'Uttarakhand',
                'slug'   => 'uttarakhand',
                'status' => 1,
            ],
            [
                'name'   => 'Sikkim',
                'slug'   => 'sikkim',
                'status' => 1,
            ],
            [
                'name'   => 'Meghalaya',
                'slug'   => 'meghalaya',
                'status' => 1,
            ],
        ];

        $this->db->table('mst_destinations')->insertBatch($data);
    }
}