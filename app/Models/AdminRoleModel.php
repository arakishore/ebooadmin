<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminRoleModel extends Model
{
    protected $table            = 'admin_roles';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'name',
        'slug',
        'description',
        'status',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;

    protected $dateFormat    = 'datetime';

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [

        'name' => 'required|min_length[2]|max_length[100]',

        'slug' => 'required|min_length[2]|max_length[100]|is_unique[admin_roles.slug,id,{id}]',

        'status' => 'required|in_list[0,1]',

    ];

    protected $validationMessages = [];

    protected $skipValidation = false;
}