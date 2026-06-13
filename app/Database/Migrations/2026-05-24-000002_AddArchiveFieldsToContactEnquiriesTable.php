<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddArchiveFieldsToContactEnquiriesTable extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('contact_enquiries')) {
            return;
        }

        if (! $this->db->fieldExists('is_archived', 'contact_enquiries')) {
            $this->forge->addColumn('contact_enquiries', [
                'is_archived' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 0,
                    'after'      => 'admin_note',
                ],
                'archived_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'is_archived',
                ],
                'archived_by' => [
                    'type'     => 'BIGINT',
                    'unsigned' => true,
                    'null'     => true,
                    'after'    => 'archived_at',
                ],
            ]);
        }

        if (! $this->indexExists('contact_enquiries', 'is_archived')) {
            $this->forge->addKey('is_archived');
            $this->forge->processIndexes('contact_enquiries');
        }
    }

    public function down()
    {
        // No-op: the main create migration also defines these columns for fresh installs.
    }

    private function indexExists(string $table, string $index): bool
    {
        $result = $this->db->query('SHOW INDEX FROM ' . $this->db->protectIdentifiers($table, true) . ' WHERE Key_name = ' . $this->db->escape($index));

        return $result->getNumRows() > 0;
    }
}
