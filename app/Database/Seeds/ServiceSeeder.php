<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $services = [
            [
                'name' => 'Hotel',
                'slug' => 'hotel',
                'short_description' => 'Book comfortable hotels for your journey.',
                'icon' => 'fa fa-hotel',
                'sort_order' => 2,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Flight',
                'slug' => 'flight',
                'short_description' => 'Domestic and international flight bookings.',
                'icon' => 'fa fa-plane',
                'sort_order' => 3,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Cruises',
                'slug' => 'cruise',
                'short_description' => 'Luxury cruise holidays and family cruise packages.',
                'icon' => 'fa fa-ship',
                'sort_order' => 4,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Car Rental',
                'slug' => 'car',
                'short_description' => 'Airport transfers and local car hire services.',
                'icon' => 'fa fa-car',
                'sort_order' => 5,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Forex',
                'slug' => 'forex',
                'short_description' => 'Foreign currency exchange and travel cards.',
                'icon' => 'fa fa-money',
                'sort_order' => 6,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Visa Assistance',
                'slug' => 'visa',
                'short_description' => 'Tourist, business and student visa support.',
                'icon' => 'fa fa-passport',
                'sort_order' => 7,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->db->table('services')->insertBatch($services);
    }
}