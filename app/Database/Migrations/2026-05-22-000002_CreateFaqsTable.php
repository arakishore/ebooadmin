<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFaqsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => true,
            ],
            'question' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
            ],
            'answer' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sort_order' => [
                'type'    => 'INT',
                'default' => 0,
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
        $this->forge->addKey('category_id');
        $this->forge->addForeignKey('category_id', 'cms_faq_categories', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('cms_faqs');
    }

    public function down()
    {
        $this->forge->dropTable('cms_faqs', true);
    }
}
