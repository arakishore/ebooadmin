<?php

namespace App\Models;

use CodeIgniter\Model;

class PackageModel extends Model
{
    protected $table            = 't_packages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'destination_id',
        'package_category_id',
        'hotel_category_id',
        'meal_plan_type_id',
        'transport_type_id',
        'title',
        'slug',
        'short_description',
        'description',
        'duration_days',
        'duration_nights',
        'starting_price',
        'sale_price',
        'featured_image',
        'banner_image',
        'is_featured',
        'status',
        'sort_order',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
}
