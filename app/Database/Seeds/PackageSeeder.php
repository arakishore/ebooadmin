<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'destination_id' => 1,
                'package_category_id' => 4,
                'hotel_category_id' => 4,
                'meal_plan_type_id' => 5,
                'transport_type_id' => 1,
                'title' => 'Kashmir Paradise Escape',
                'slug' => 'kashmir-paradise-escape',
                'short_description' => 'Experience the beauty of Kashmir with scenic valleys, shikara rides, and snow-capped mountains.',
                'description' => 'Enjoy a relaxing Kashmir holiday featuring Srinagar houseboat stay, Gulmarg sightseeing, local cuisine, and breathtaking Himalayan landscapes perfect for couples and families.',
                'duration_days' => 6,
                'duration_nights' => 5,
                'starting_price' => 28999.00,
                'sale_price' => 25999.00,
                'featured_image' => 'packages/kashmir-paradise-escape-featured.jpg',
                'banner_image' => 'packages/kashmir-paradise-escape-banner.jpg',
                'is_featured' => 1,
                'status' => 1,
            ],

            [
                'destination_id' => 2,
                'package_category_id' => 2,
                'hotel_category_id' => 3,
                'meal_plan_type_id' => 3,
                'transport_type_id' => 2,
                'title' => 'Goa Beach Holiday',
                'slug' => 'goa-beach-holiday',
                'short_description' => 'Relax on the sunny beaches of Goa with vibrant nightlife and water adventures.',
                'description' => 'Explore North and South Goa with comfortable beach resort stays, water sports, sunset cruises, and local seafood experiences ideal for friends and families.',
                'duration_days' => 5,
                'duration_nights' => 4,
                'starting_price' => 15999.00,
                'sale_price' => 13999.00,
                'featured_image' => 'packages/goa-beach-holiday-featured.jpg',
                'banner_image' => 'packages/goa-beach-holiday-banner.jpg',
                'is_featured' => 1,
                'status' => 1,
            ],

            [
                'destination_id' => 3,
                'package_category_id' => 3,
                'hotel_category_id' => 5,
                'meal_plan_type_id' => 4,
                'transport_type_id' => 1,
                'title' => 'Kerala Backwater Retreat',
                'slug' => 'kerala-backwater-retreat',
                'short_description' => 'Discover Kerala with serene backwaters, hill stations, and Ayurvedic wellness.',
                'description' => 'Experience the charm of Kerala through houseboat cruises in Alleppey, Munnar tea gardens, cultural performances, and authentic South Indian hospitality.',
                'duration_days' => 7,
                'duration_nights' => 6,
                'starting_price' => 24999.00,
                'sale_price' => 21999.00,
                'featured_image' => 'packages/kerala-backwater-retreat-featured.jpg',
                'banner_image' => 'packages/kerala-backwater-retreat-banner.jpg',
                'is_featured' => 1,
                'status' => 1,
            ],

            [
                'destination_id' => 4,
                'package_category_id' => 1,
                'hotel_category_id' => 4,
                'meal_plan_type_id' => 2,
                'transport_type_id' => 1,
                'title' => 'Rajasthan Royal Heritage Tour',
                'slug' => 'rajasthan-royal-heritage-tour',
                'short_description' => 'Explore majestic forts, royal palaces, and desert culture across Rajasthan.',
                'description' => 'Travel through Jaipur, Jodhpur, and Udaipur with heritage hotel stays, camel safari experiences, and guided city tours showcasing royal Rajasthan.',
                'duration_days' => 8,
                'duration_nights' => 7,
                'starting_price' => 32999.00,
                'sale_price' => 29999.00,
                'featured_image' => 'packages/rajasthan-royal-heritage-tour-featured.jpg',
                'banner_image' => 'packages/rajasthan-royal-heritage-tour-banner.jpg',
                'is_featured' => 0,
                'status' => 1,
            ],

            [
                'destination_id' => 5,
                'package_category_id' => 5,
                'hotel_category_id' => 5,
                'meal_plan_type_id' => 5,
                'transport_type_id' => 1,
                'title' => 'Leh Ladakh Adventure Ride',
                'slug' => 'leh-ladakh-adventure-ride',
                'short_description' => 'An unforgettable Ladakh adventure with mountain passes, monasteries, and lakes.',
                'description' => 'Ride through the breathtaking roads of Leh Ladakh, visit Pangong Lake, Nubra Valley, and ancient monasteries with guided adventure support.',
                'duration_days' => 9,
                'duration_nights' => 8,
                'starting_price' => 38999.00,
                'sale_price' => 35999.00,
                'featured_image' => 'packages/leh-ladakh-adventure-ride-featured.jpg',
                'banner_image' => 'packages/leh-ladakh-adventure-ride-banner.jpg',
                'is_featured' => 1,
                'status' => 1,
            ],
        ];

        $this->db->table('t_packages')->insertBatch($data);
    }
}