<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CmsFaqCategorySeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        //$this->db->table('cms_faq_categories')->truncate();

        $data = [
            [
                'name'       => 'Booking & Reservations',
                'slug'       => 'booking-reservations',
                'sort_order' => 1,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Payments & Pricing',
                'slug'       => 'payments-pricing',
                'sort_order' => 2,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Travel Documents',
                'slug'       => 'travel-documents',
                'sort_order' => 3,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Accommodation',
                'slug'       => 'accommodation',
                'sort_order' => 4,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Transportation',
                'slug'       => 'transportation',
                'sort_order' => 5,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Cancellations & Refunds',
                'slug'       => 'cancellations-refunds',
                'sort_order' => 6,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Local Experience',
                'slug'       => 'local-experience',
                'sort_order' => 7,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Safety & Health',
                'slug'       => 'safety-health',
                'sort_order' => 8,
                'status'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        $this->db->table('cms_faq_categories')->insertBatch($data);
    }
}
