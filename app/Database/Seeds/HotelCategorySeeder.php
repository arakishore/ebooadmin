<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HotelCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => '3 Star', 'slug' => '3-star', 'status' => 1],
            ['name' => '4 Star', 'slug' => '4-star', 'status' => 1],
            ['name' => '5 Star', 'slug' => '5-star', 'status' => 1],
            ['name' => 'Luxury Resort', 'slug' => 'luxury-resort', 'status' => 1],
            ['name' => 'Boutique Hotel', 'slug' => 'boutique-hotel', 'status' => 1],
        ];

        $this->db->table('mst_hotel_categories')->insertBatch($data);
    }
}