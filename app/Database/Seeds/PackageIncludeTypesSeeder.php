<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackageIncludeTypesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'Flight Tickets',
                'slug'       => 'flight-tickets',
                'description'=> 'Roundtrip airfare for all travelers included in the package.',
                'icon'       => 'icon-plane',
                'status'     => 1,
                'sort_order' => 1,
            ],
            [
                'name'       => 'Hotel Accommodation',
                'slug'       => 'hotel-accommodation',
                'description'=> 'Comfortable hotel stays with breakfast included.',
                'icon'       => 'icon-hotel',
                'status'     => 1,
                'sort_order' => 2,
            ],
            [
                'name'       => 'Daily Breakfast',
                'slug'       => 'daily-breakfast',
                'description'=> 'Breakfast served every morning during the stay.',
                'icon'       => 'icon-coffee',
                'status'     => 1,
                'sort_order' => 3,
            ],
            [
                'name'       => 'Airport Transfer',
                'slug'       => 'airport-transfer',
                'description'=> 'Pick-up and drop-off transfers to/from the airport.',
                'icon'       => 'icon-car',
                'status'     => 1,
                'sort_order' => 4,
            ],
            [
                'name'       => 'Guided Tours',
                'slug'       => 'guided-tours',
                'description'=> 'Professional guides for sightseeing tours and local excursions.',
                'icon'       => 'icon-map',
                'status'     => 1,
                'sort_order' => 5,
            ],
            [
                'name'       => 'Travel Insurance',
                'slug'       => 'travel-insurance',
                'description'=> 'Travel insurance coverage for health, baggage, and delays.',
                'icon'       => 'icon-shield',
                'status'     => 1,
                'sort_order' => 6,
            ],
        ];

        $this->db->table('mst_package_include_types')->insertBatch($data);
    }
}
