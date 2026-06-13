<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        //$this->db->disableForeignKeyChecks();

        // Child tables first
        $this->db->table('t_package_activities')->truncate();
        $this->db->table('t_package_amenities')->truncate();
        $this->db->table('t_package_excludes')->truncate();
        $this->db->table('t_package_facts')->truncate();
        $this->db->table('t_package_images')->truncate();
        $this->db->table('t_package_includes')->truncate();
        $this->db->table('t_package_itineraries')->truncate();
        $this->db->table('t_package_hotels')->truncate();

        $this->db->table('mst_hotels')->truncate();

        // Main package table
        $this->db->table('t_packages')->truncate();

        // Master tables
        $this->db->table('mst_activity_types')->truncate();
        $this->db->table('mst_amenity_types')->truncate();
        $this->db->table('mst_destinations')->truncate();
        $this->db->table('mst_hotel_categories')->truncate();
        $this->db->table('mst_meal_plan_types')->truncate();
        $this->db->table('mst_package_categories')->truncate();
        $this->db->table('mst_package_exclude_types')->truncate();
        $this->db->table('mst_package_fact_types')->truncate();
        $this->db->table('mst_package_include_types')->truncate();
        $this->db->table('mst_transport_types')->truncate();
        $this->db->table('cms_faqs')->truncate();
        $this->db->table('cms_faq_categories')->truncate();
        $this->db->table('cms_testimonials')->truncate();

        //$this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        $this->db->enableForeignKeyChecks();

        // Master seeders first
        $this->call(DestinationSeeder::class);
        $this->call(PackageCategorySeeder::class);
        $this->call(ActivityTypeSeeder::class);
        $this->call(AmenityTypeSeeder::class);
        $this->call(HotelCategorySeeder::class);
        $this->call(HotelSeeder::class);
        $this->call(TransportTypeSeeder::class);
        $this->call(MealPlanTypesSeeder::class);
        $this->call(PackageIncludeTypesSeeder::class);
        $this->call(PackageExcludeTypesSeeder::class);
        $this->call(PackageFactTypesSeeder::class);
        $this->call(CmsFaqCategorySeeder::class);
        $this->call(CmsFaqSeeder::class);
        $this->call(CmsTestimonialsSeeder::class);

        // Package table
        $this->call(PackageSeeder::class);

        // Package child seeders

        $this->call(PackageItinerarySeeder::class);
        $this->call(PackageFactSeeder::class);
        $this->call(PackageIncludeSeeder::class);
        $this->call(PackageExcludeSeeder::class);
        $this->call(PackageActivitySeeder::class);
        $this->call(PackageAmenitySeeder::class);
        $this->call(ContactEnquirySeeder::class);
    }
}
