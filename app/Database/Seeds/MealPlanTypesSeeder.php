<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MealPlanTypesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['name' => 'Room Only', 'slug' => 'room-only', 'status' => 1],
            ['name' => 'Bed and Breakfast', 'slug' => 'bed-and-breakfast', 'status' => 1],
            ['name' => 'Half Board', 'slug' => 'half-board', 'status' => 1],
            ['name' => 'Full Board', 'slug' => 'full-board', 'status' => 1],
            ['name' => 'All Inclusive', 'slug' => 'all-inclusive', 'status' => 1],
            ['name' => 'Premium All Inclusive', 'slug' => 'premium-all-inclusive', 'status' => 1],
        ];

        $this->db->table('mst_meal_plan_types')->insertBatch($data);
    }
}
