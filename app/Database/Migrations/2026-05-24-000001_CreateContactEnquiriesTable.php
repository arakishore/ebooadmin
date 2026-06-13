<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactEnquiriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'enquiry_type' => [
                'type'       => 'ENUM',
                'constraint' => ['contact', 'package', 'hotel', 'car', 'forex', 'cruise', 'visa', 'flight'],
            ],
            'package_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
            ],
            'hotel_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
            ],
            'hotel_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'pickup_location' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'dropoff_location' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
            ],
            'subject' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'message' => [
                'type' => 'TEXT',
            ],
            'travel_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'check_in' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'check_out' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'pickup_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'dropoff_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'adults' => [
                'type' => 'INT',
                'null' => true,
            ],
            'children' => [
                'type' => 'INT',
                'null' => true,
            ],
            'rooms' => [
                'type' => 'INT',
                'null' => true,
            ],
            'passengers' => [
                'type' => 'INT',
                'null' => true,
            ],
            'vehicle_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'is_air_con' => [
                'type'    => 'INT',
                'default' => 1,
            ],
            'currency_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'currency_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'new',
            ],
            'viewed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'viewed_by' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
            ],
            'replied_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'replied_by' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
            ],
            'reply_message' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'admin_note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'page_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'referrer_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'utm_source' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'utm_medium' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'utm_campaign' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'source' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'website',
            ],
            'is_archived' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'archived_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'archived_by' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('enquiry_type');
        $this->forge->addKey('package_id');
        $this->forge->addKey('hotel_id');
        $this->forge->addKey('status');
        $this->forge->addKey('created_at');
        $this->forge->addKey('is_archived');
        $this->forge->addKey('ip_address');
        $this->forge->addKey('utm_source');
        $this->forge->addKey('source');
        $this->forge->addKey(['enquiry_type', 'status']);

        $this->forge->addForeignKey('package_id', 't_packages', 'id', 'CASCADE', 'SET NULL');

        $this->forge->createTable('contact_enquiries');
    }

    public function down()
    {
        $this->forge->dropTable('contact_enquiries', true);
    }
}
