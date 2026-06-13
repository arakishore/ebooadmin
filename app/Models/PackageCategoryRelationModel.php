<?php

namespace App\Models;

use CodeIgniter\Model;

class PackageCategoryRelationModel extends Model
{
    protected $table            = 't_package_category_relations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'package_id',
        'category_id',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = true;
}
