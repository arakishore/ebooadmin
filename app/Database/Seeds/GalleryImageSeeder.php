<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'gallery_type' => 'hotel',
                'image'        => 'uploads/gallery/hotel/original/hotel-1.jpg',
                'status'       => 1,
            ],
            [
                'gallery_type' => 'car',
                'image'        => 'uploads/gallery/car/original/car-1.jpg',
                'status'       => 1,
            ],
            [
                'gallery_type' => 'cruise',
                'image'        => 'uploads/gallery/cruise/original/cruise-1.jpg',
                'status'       => 1,
            ],
            [
                'gallery_type' => 'flight',
                'image'        => 'uploads/gallery/flight/original/flight-1.jpg',
                'status'       => 1,
            ],
             
            
        ];

        $this->db->table('gallery_images')->insertBatch($data);
    }
}
