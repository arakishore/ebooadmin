<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run()
    {
        $this->call(CitySeeder::class);

        $now = date('Y-m-d H:i:s');

        $hotels = [
            ['name' => 'Taj Palace', 'hotel_code' => 'TAJ-DEL', 'category_name' => '5 Star', 'city_code' => 'DEL', 'state_id' => 4021, 'address' => 'Sardar Patel Marg, Diplomatic Enclave, New Delhi', 'image' => 'hotels/taj-palace-new-delhi.jpg'],
            ['name' => 'The Oberoi', 'hotel_code' => 'OBE-DEL', 'category_name' => '5 Star', 'city_code' => 'DEL', 'state_id' => 4021, 'address' => 'Dr Zakir Hussain Marg, New Delhi', 'image' => 'hotels/the-oberoi-new-delhi.jpg'],
            ['name' => 'Taj Mahal Palace', 'hotel_code' => 'TAJ-MUM', 'category_name' => '5 Star', 'city_code' => 'MUM', 'state_id' => 4008, 'address' => 'Apollo Bunder, Colaba, Mumbai', 'image' => 'hotels/taj-mahal-palace-mumbai.jpg'],
            ['name' => 'The Oberoi', 'hotel_code' => 'OBE-MUM', 'category_name' => '5 Star', 'city_code' => 'MUM', 'state_id' => 4008, 'address' => 'Nariman Point, Mumbai', 'image' => 'hotels/the-oberoi-mumbai.jpg'],
            ['name' => 'ITC Grand Central', 'hotel_code' => 'ITC-MUM', 'category_name' => '5 Star', 'city_code' => 'MUM', 'state_id' => 4008, 'address' => 'Dr Babasaheb Ambedkar Road, Parel, Mumbai', 'image' => 'hotels/itc-grand-central-mumbai.jpg'],
            ['name' => 'Le Meridien', 'hotel_code' => 'LMD-JAI', 'category_name' => '5 Star', 'city_code' => 'JAI', 'state_id' => 4014, 'address' => 'RIICO Kukas, Jaipur', 'image' => 'hotels/le-meridien-jaipur.jpg'],
            ['name' => 'Rambagh Palace', 'hotel_code' => 'RAM-JAI', 'category_name' => '5 Star', 'city_code' => 'JAI', 'state_id' => 4014, 'address' => 'Bhawani Singh Road, Jaipur', 'image' => 'hotels/rambagh-palace-jaipur.jpg'],
            ['name' => 'Radisson Blu', 'hotel_code' => 'RAD-UDI', 'category_name' => '5 Star', 'city_code' => 'UDI', 'state_id' => 4014, 'address' => 'Near Fateh Sagar Lake, Udaipur', 'image' => 'hotels/radisson-blu-udaipur.jpg'],
            ['name' => 'Hyatt Regency', 'hotel_code' => 'HYA-PUN', 'category_name' => '5 Star', 'city_code' => 'PUN', 'state_id' => 4008, 'address' => 'Weikfield IT Park, Nagar Road, Pune', 'image' => 'hotels/hyatt-regency-pune.jpg'],
            ['name' => 'Novotel', 'hotel_code' => 'NOV-GOA', 'category_name' => '4 Star', 'city_code' => 'GOA', 'state_id' => 4009, 'address' => 'Candolim, Goa', 'image' => 'hotels/novotel-goa.jpg'],
            ['name' => 'Marriott Resort', 'hotel_code' => 'MAR-GOA', 'category_name' => 'Luxury Resort', 'city_code' => 'GOA', 'state_id' => 4009, 'address' => 'Miramar, Panaji, Goa', 'image' => 'hotels/marriott-resort-goa.jpg'],
            ['name' => 'Holiday Inn', 'hotel_code' => 'HOL-COK', 'category_name' => '4 Star', 'city_code' => 'COK', 'state_id' => 4028, 'address' => 'Chakkaraparambu, Kochi', 'image' => 'hotels/holiday-inn-kochi.jpg'],
            ['name' => 'Ramada Resort', 'hotel_code' => 'RAM-MUN', 'category_name' => 'Luxury Resort', 'city_code' => 'MUN', 'state_id' => 4028, 'address' => 'Chinnakanal, Munnar', 'image' => 'hotels/ramada-resort-munnar.jpg'],
            ['name' => 'The Lalit Grand Palace', 'hotel_code' => 'LAL-SXR', 'category_name' => '5 Star', 'city_code' => 'SXR', 'state_id' => 4029, 'address' => 'Gupkar Road, Srinagar', 'image' => 'hotels/the-lalit-grand-palace-srinagar.jpg'],
            ['name' => 'ITC Gardenia', 'hotel_code' => 'ITC-BLR', 'category_name' => '5 Star', 'city_code' => 'BLR', 'state_id' => 4026, 'address' => 'Residency Road, Bengaluru', 'image' => 'hotels/itc-gardenia-bengaluru.jpg'],
        ];

        $cityCodes = array_unique(array_column($hotels, 'city_code'));
        $categoryNames = array_unique(array_column($hotels, 'category_name'));

        $cities = $this->db->table('mst_cities')
            ->where('country_id', 101)
            ->whereIn('city_code', $cityCodes)
            ->get()
            ->getResultArray();

        $citiesByCode = array_column($cities, null, 'city_code');

        $categories = $this->db->table('mst_hotel_categories')
            ->whereIn('name', $categoryNames)
            ->get()
            ->getResultArray();

        $categoriesByName = [];

        foreach ($categories as $category) {
            $categoriesByName[strtolower($category['name'])] = $category;
        }

        $hotelNames = array_unique(array_column($hotels, 'name'));
        $cityIds = array_column($cities, 'id');

        if ($cityIds === []) {
            return;
        }

        $existingHotels = $this->db->table('mst_hotels')
            ->whereIn('name', $hotelNames)
            ->whereIn('city_id', $cityIds)
            ->get()
            ->getResultArray();

        $existingByNameCity = [];

        foreach ($existingHotels as $hotel) {
            $existingByNameCity[strtolower($hotel['name']) . '|' . $hotel['city_id']] = $hotel;
        }

        $insertData = [];
        $updateData = [];
        $sortOrder = 1;

        foreach ($hotels as $hotel) {
            if (! isset($citiesByCode[$hotel['city_code']])) {
                $sortOrder++;
                continue;
            }

            $cityId = $citiesByCode[$hotel['city_code']]['id'];
            $categoryKey = strtolower($hotel['category_name']);

            if (! isset($categoriesByName[$categoryKey])) {
                throw new \RuntimeException('Hotel category not found: ' . $hotel['category_name']);
            }

            $key = strtolower($hotel['name']) . '|' . $cityId;

            $data = [
                'name'              => $hotel['name'],
                'hotel_code'        => $hotel['hotel_code'],
                'hotel_category_id' => $categoriesByName[$categoryKey]['id'],
                'country_id'        => 101,
                'state_id'          => $hotel['state_id'],
                'city_id'           => $cityId,
                'address'           => $hotel['address'],
                'image'             => $hotel['image'],
                'status'            => 1,
                'sort_order'        => $sortOrder,
                'updated_at'        => $now,
                'deleted_at'        => null,
            ];

            if (isset($existingByNameCity[$key])) {
                $data['id'] = $existingByNameCity[$key]['id'];
                $updateData[] = $data;
            } else {
                $data['created_at'] = $now;
                $insertData[] = $data;
            }

            $sortOrder++;
        }

        if ($insertData) {
            $this->db->table('mst_hotels')->insertBatch($insertData);
        }

        if ($updateData) {
            $this->db->table('mst_hotels')->updateBatch($updateData, 'id');
        }
    }
}
