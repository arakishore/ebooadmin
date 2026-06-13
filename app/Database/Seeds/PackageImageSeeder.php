<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackageImageSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['package_id' => 1, 'image' => 'packages/dubai-desert-1.jpg', 'alt_text' => 'Dubai desert safari dunes', 'sort_order' => 1,  'status' => 1],
            ['package_id' => 1, 'image' => 'packages/dubai-desert-2.jpg', 'alt_text' => 'Luxury desert camp experience', 'sort_order' => 2,  'status' => 1],
            ['package_id' => 1, 'image' => 'packages/dubai-city-skyline.jpg', 'alt_text' => 'Dubai city skyline at sunset', 'sort_order' => 3,  'status' => 1],
            ['package_id' => 2, 'image' => 'packages/thailand-family-1.jpg', 'alt_text' => 'Family enjoying a beach in Thailand', 'sort_order' => 1,  'status' => 1],
            ['package_id' => 2, 'image' => 'packages/thailand-family-2.jpg', 'alt_text' => 'Cultural temple visit with children', 'sort_order' => 2,  'status' => 1],
            ['package_id' => 2, 'image' => 'packages/thailand-family-3.jpg', 'alt_text' => 'Hotel pool for the whole family', 'sort_order' => 3,  'status' => 1],
            ['package_id' => 3, 'image' => 'packages/bali-adventure-1.jpg', 'alt_text' => 'Bali jungle trek trail', 'sort_order' => 1,  'status' => 1],
            ['package_id' => 3, 'image' => 'packages/bali-adventure-2.jpg', 'alt_text' => 'Boutique hotel terrace in Bali', 'sort_order' => 2,  'status' => 1],
            ['package_id' => 3, 'image' => 'packages/bali-adventure-3.jpg', 'alt_text' => 'Bali beachside sunset', 'sort_order' => 3,  'status' => 1],
        ];

        $this->db->table('t_package_images')->insertBatch($data);
    }
}
