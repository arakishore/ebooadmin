<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGalleryImagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'gallery_type' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'hotel',
                    'car',
                    'cruise',
                    'flight',
                    'visa',
                    'forex',
                    'package',
                ],
            ],

            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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
        $this->forge->addKey('gallery_type');
        $this->forge->addKey('status');

        $this->forge->createTable('gallery_images');
    }

    public function down()
    {
        $this->forge->dropTable('gallery_images', true);
    }
}
