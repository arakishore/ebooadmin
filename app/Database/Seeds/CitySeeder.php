<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $cities = [
            ['name' => 'Mumbai', 'city_code' => 'MUM', 'state_id' => 4008, 'country_id' => 101],
            ['name' => 'Pune', 'city_code' => 'PUN', 'state_id' => 4008, 'country_id' => 101],
            ['name' => 'Goa', 'city_code' => 'GOA', 'state_id' => 4009, 'country_id' => 101],
            ['name' => 'Jaipur', 'city_code' => 'JAI', 'state_id' => 4014, 'country_id' => 101],
            ['name' => 'Udaipur', 'city_code' => 'UDI', 'state_id' => 4014, 'country_id' => 101],
            ['name' => 'New Delhi', 'city_code' => 'DEL', 'state_id' => 4021, 'country_id' => 101],
            ['name' => 'Agra', 'city_code' => 'AGR', 'state_id' => 4022, 'country_id' => 101],
            ['name' => 'Bengaluru', 'city_code' => 'BLR', 'state_id' => 4026, 'country_id' => 101],
            ['name' => 'Kochi', 'city_code' => 'COK', 'state_id' => 4028, 'country_id' => 101],
            ['name' => 'Munnar', 'city_code' => 'MUN', 'state_id' => 4028, 'country_id' => 101],
            ['name' => 'Srinagar', 'city_code' => 'SXR', 'state_id' => 4029, 'country_id' => 101],
            ['name' => 'Ahmedabad', 'city_code' => 'AMD', 'state_id' => 4030, 'country_id' => 101],
            ['name' => 'Chennai', 'city_code' => 'MAA', 'state_id' => 4035, 'country_id' => 101],
            ['name' => 'Kolkata', 'city_code' => 'CCU', 'state_id' => 4853, 'country_id' => 101],
        ];

        $cityCodes = array_column($cities, 'city_code');
        $cityNames = array_column($cities, 'name');

        $existingCities = $this->db->table('mst_cities')
            ->where('country_id', 101)
            ->groupStart()
                ->whereIn('city_code', $cityCodes)
                ->orWhereIn('name', $cityNames)
            ->groupEnd()
            ->get()
            ->getResultArray();

        $existingByCode = [];
        $existingByName = [];

        foreach ($existingCities as $city) {
            if (! empty($city['city_code'])) {
                $existingByCode[$city['city_code']] = $city;
            }

            $existingByName[strtolower($city['name'])] = $city;
        }

        $insertData = [];
        $updateData = [];

        foreach ($cities as $city) {
            $existingCity = $existingByCode[$city['city_code']]
                ?? $existingByName[strtolower($city['name'])]
                ?? null;

            $data = [
                'name'       => $city['name'],
                'city_code'  => $city['city_code'],
                'state_id'   => $city['state_id'],
                'country_id' => $city['country_id'],
                'updated_at' => $now,
                'deleted_at' => null,
            ];

            if ($existingCity) {
                $data['id'] = $existingCity['id'];
                $updateData[] = $data;
                continue;
            }

            $data['created_at'] = $now;
            $insertData[] = $data;
        }

        if ($insertData) {
            $this->db->table('mst_cities')->insertBatch($insertData);
        }

        if ($updateData) {
            $this->db->table('mst_cities')->updateBatch($updateData, 'id');
        }
    }
}
