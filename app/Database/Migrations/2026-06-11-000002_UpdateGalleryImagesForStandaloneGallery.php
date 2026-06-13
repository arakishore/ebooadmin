<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateGalleryImagesForStandaloneGallery extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('gallery_images')) {
            return;
        }

        foreach (['title', 'alt_text', 'description', 'sort_order'] as $field) {
            if ($this->db->fieldExists($field, 'gallery_images')) {
                $this->forge->dropColumn('gallery_images', $field);
            }
        }
    }

    public function down()
    {
        // No-op: the gallery module intentionally uses only minimal image fields.
    }
}
