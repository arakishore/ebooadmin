<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateContactEnquiriesForHotelEnquiries extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('contact_enquiries')) {
            return;
        }

        $this->forge->modifyColumn('contact_enquiries', [
            'enquiry_type' => [
                'name'       => 'enquiry_type',
                'type'       => 'ENUM',
                'constraint' => ['contact', 'package', 'hotel', 'car', 'forex', 'cruise', 'visa', 'flight'],
            ],
        ]);

        if ($this->db->fieldExists('hotel_name ', 'contact_enquiries') && ! $this->db->fieldExists('hotel_name', 'contact_enquiries')) {
            $this->forge->modifyColumn('contact_enquiries', [
                'hotel_name ' => [
                    'name'       => 'hotel_name',
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'hotel_id',
                ],
            ]);
        }

        if (! $this->db->fieldExists('hotel_id', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'hotel_id' => [
                    'type'     => 'BIGINT',
                    'unsigned' => true,
                    'null'     => true,
                    'after'    => 'package_id',
                ],
            ]);
        } else {
            $this->forge->modifyColumn('contact_enquiries', [
                'hotel_id' => [
                    'name'     => 'hotel_id',
                    'type'     => 'BIGINT',
                    'unsigned' => true,
                    'null'     => true,
                    'after'    => 'package_id',
                ],
            ]);
        }

        if (! $this->db->fieldExists('hotel_name', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'hotel_name' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'hotel_id',
                ],
            ]);
        } else {
            $this->forge->modifyColumn('contact_enquiries', [
                'hotel_name' => [
                    'name'       => 'hotel_name',
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'hotel_id',
                ],
            ]);
        }

        if (! $this->db->fieldExists('check_in', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'check_in' => [
                    'type'  => 'DATE',
                    'null'  => true,
                    'after' => 'travel_date',
                ],
            ]);
        } else {
            $this->forge->modifyColumn('contact_enquiries', [
                'check_in' => [
                    'name'  => 'check_in',
                    'type'  => 'DATE',
                    'null'  => true,
                    'after' => 'travel_date',
                ],
            ]);
        }

        if (! $this->db->fieldExists('check_out', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'check_out' => [
                    'type'  => 'DATE',
                    'null'  => true,
                    'after' => 'check_in',
                ],
            ]);
        } else {
            $this->forge->modifyColumn('contact_enquiries', [
                'check_out' => [
                    'name'  => 'check_out',
                    'type'  => 'DATE',
                    'null'  => true,
                    'after' => 'check_in',
                ],
            ]);
        }

        if (! $this->db->fieldExists('rooms', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'rooms' => [
                    'type'  => 'INT',
                    'null'  => true,
                    'after' => 'children',
                ],
            ]);
        } else {
            $this->forge->modifyColumn('contact_enquiries', [
                'rooms' => [
                    'name'  => 'rooms',
                    'type'  => 'INT',
                    'null'  => true,
                    'after' => 'children',
                ],
            ]);
        }

        if (! $this->db->fieldExists('pickup_location', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'pickup_location' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'hotel_name',
                ],
            ]);
        }

        if (! $this->db->fieldExists('dropoff_location', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'dropoff_location' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'pickup_location',
                ],
            ]);
        }

        if (! $this->db->fieldExists('pickup_date', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'pickup_date' => [
                    'type'  => 'DATE',
                    'null'  => true,
                    'after' => 'check_out',
                ],
            ]);
        }

        if (! $this->db->fieldExists('dropoff_date', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'dropoff_date' => [
                    'type'  => 'DATE',
                    'null'  => true,
                    'after' => 'pickup_date',
                ],
            ]);
        }

        if (! $this->db->fieldExists('passengers', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'passengers' => [
                    'type'  => 'INT',
                    'null'  => true,
                    'after' => 'rooms',
                ],
            ]);
        }

        if (! $this->db->fieldExists('vehicle_type', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'vehicle_type' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                    'after'      => 'passengers',
                ],
            ]);
        }

        if (! $this->db->fieldExists('is_air_con', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'is_air_con' => [
                    'type'    => 'INT',
                    'default' => 1,
                    'after'   => 'vehicle_type',
                ],
            ]);
        }

        if (! $this->db->fieldExists('currency_type', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'currency_type' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true,
                    'after'      => 'is_air_con',
                ],
            ]);
        }

        if (! $this->db->fieldExists('currency_amount', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'currency_amount' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '12,2',
                    'null'       => true,
                    'after'      => 'currency_type',
                ],
            ]);
        } else {
            $this->forge->modifyColumn('contact_enquiries', [
                'currency_amount' => [
                    'name'       => 'currency_amount',
                    'type'       => 'DECIMAL',
                    'constraint' => '12,2',
                    'null'       => true,
                    'after'      => 'currency_type',
                ],
            ]);
        }

        if (! $this->indexExists('contact_enquiries', 'hotel_id')) {
            $this->forge->addKey('hotel_id');
            $this->forge->processIndexes('contact_enquiries');
        }

        if (! $this->indexExists('contact_enquiries', 'idx_enquiry_type_status')) {
            $this->db->query('CREATE INDEX idx_enquiry_type_status ON contact_enquiries (enquiry_type, status)');
        }
    }

    public function down()
    {
        // No-op: keep submitted lead data intact.
    }

    private function indexExists(string $table, string $index): bool
    {
        $result = $this->db->query('SHOW INDEX FROM ' . $this->db->protectIdentifiers($table, true) . ' WHERE Key_name = ' . $this->db->escape($index));

        return $result->getNumRows() > 0;
    }
}
