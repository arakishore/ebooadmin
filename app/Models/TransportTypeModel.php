<?php

namespace App\Models;

use CodeIgniter\Model;

class TransportTypeModel extends Model
{
    protected $table            = 'mst_transport_types';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'name',
        'slug',
        'description',
        'icon',
        'status',
        'sort_order',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = true;
}
