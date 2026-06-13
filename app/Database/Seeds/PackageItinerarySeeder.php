<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackageItinerarySeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['package_id' => 1, 'day_number' => 1, 'title' => 'Arrival and Luxury Transfer', 'description' => 'Arrive in Dubai and enjoy a private transfer to your luxury resort with welcome refreshments.', 'meals' => 'Dinner', 'overnight_stay' => 'Luxury Resort', 'sort_order' => 1, 'status' => 1],
            ['package_id' => 1, 'day_number' => 2, 'title' => 'City Tour and Marina Cruise', 'description' => 'Explore Dubai highlights including the Burj Khalifa, Dubai Mall, and an evening cruise on Dubai Marina.', 'meals' => 'Breakfast', 'overnight_stay' => 'Luxury Resort', 'sort_order' => 2, 'status' => 1],
            ['package_id' => 1, 'day_number' => 3, 'title' => 'Desert Safari Adventure', 'description' => 'Head into the desert for dune bashing, camel rides, and a cultural camp dinner under the stars.', 'meals' => 'Breakfast, Dinner', 'overnight_stay' => 'Luxury Resort', 'sort_order' => 3, 'status' => 1],
            ['package_id' => 1, 'day_number' => 4, 'title' => 'Beach Relaxation Day', 'description' => 'Spend a relaxing day at the resort beach with optional water sports and spa appointments.', 'meals' => 'Breakfast', 'overnight_stay' => 'Luxury Resort', 'sort_order' => 4, 'status' => 1],
            ['package_id' => 1, 'day_number' => 5, 'title' => 'Departure', 'description' => 'Enjoy a final morning at leisure before your private transfer to the airport for departure.', 'meals' => 'Breakfast', 'overnight_stay' => null, 'sort_order' => 5, 'status' => 1],
            ['package_id' => 2, 'day_number' => 1, 'title' => 'Bangkok Welcome and City Introduction', 'description' => 'Arrive in Bangkok, transfer to your hotel, and enjoy an orientation tour of local highlights.', 'meals' => 'Dinner', 'overnight_stay' => '4 Star Hotel', 'sort_order' => 1, 'status' => 1],
            ['package_id' => 2, 'day_number' => 2, 'title' => 'Temple Tour and River Cruise', 'description' => 'Visit Bangkok temples, explore the Chao Phraya River, and enjoy a family-friendly river cruise.', 'meals' => 'Breakfast', 'overnight_stay' => '4 Star Hotel', 'sort_order' => 2, 'status' => 1],
            ['package_id' => 2, 'day_number' => 3, 'title' => 'Beach Transfer to Phuket', 'description' => 'Fly or transfer to Phuket and spend the afternoon relaxing by the beach with family entertainment.', 'meals' => 'Breakfast', 'overnight_stay' => '4 Star Hotel', 'sort_order' => 3, 'status' => 1],
            ['package_id' => 2, 'day_number' => 4, 'title' => 'Island Exploration', 'description' => 'Take a guided island tour to nearby beaches, snorkel spots, and coastal viewpoints.', 'meals' => 'Breakfast', 'overnight_stay' => '4 Star Hotel', 'sort_order' => 4, 'status' => 1],
            ['package_id' => 2, 'day_number' => 5, 'title' => 'Departure Day', 'description' => 'Enjoy a final breakfast and transfer to the airport for your flight home.', 'meals' => 'Breakfast', 'overnight_stay' => null, 'sort_order' => 5, 'status' => 1],
            ['package_id' => 3, 'day_number' => 1, 'title' => 'Welcome to Bali', 'description' => 'Arrive in Bali and settle into your boutique hotel with a welcome drink and sunset view.', 'meals' => 'Dinner', 'overnight_stay' => 'Boutique Hotel', 'sort_order' => 1, 'status' => 1],
            ['package_id' => 3, 'day_number' => 2, 'title' => 'Rice Terrace Trek', 'description' => 'Explore Bali rice terraces, waterfalls, and cultural villages with a local guide.', 'meals' => 'Breakfast, Lunch', 'overnight_stay' => 'Boutique Hotel', 'sort_order' => 2, 'status' => 1],
            ['package_id' => 3, 'day_number' => 3, 'title' => 'Beach and Water Sports', 'description' => 'Enjoy an active day on the beach with optional water sports and beachside relaxation.', 'meals' => 'Breakfast', 'overnight_stay' => 'Boutique Hotel', 'sort_order' => 3, 'status' => 1],
            ['package_id' => 3, 'day_number' => 4, 'title' => 'Cultural Village Experience', 'description' => 'Visit local temples, watch traditional dance, and learn about Balinese crafts.', 'meals' => 'Breakfast', 'overnight_stay' => 'Boutique Hotel', 'sort_order' => 4, 'status' => 1],
            ['package_id' => 3, 'day_number' => 5, 'title' => 'Final Leisure Day', 'description' => 'Relax at the resort or explore coastal markets before your departure.', 'meals' => 'Breakfast', 'overnight_stay' => 'Boutique Hotel', 'sort_order' => 5, 'status' => 1],
        ];

        $this->db->table('t_package_itineraries')->insertBatch($data);
    }
}
