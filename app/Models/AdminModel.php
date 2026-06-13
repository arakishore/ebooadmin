<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table            = 'admins';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'role_id',
        'name',
        'email',
        'mobile',
        'password',
        'profile_image',
        'status',
        'last_login_at',
        'last_login_ip',
        'email_verified_at',
        'password_changed_at',
        'remember_token',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'role_id'  => 'required',
        'name'     => 'required|min_length[2]|max_length[100]',
        'email'    => 'required|valid_email|is_unique[admins.email,id,{id}]',
        'password' => 'permit_empty|min_length[6]',
        'status'   => 'required|in_list[0,1]',
    ];

    protected $validationMessages = [];
    protected $skipValidation     = false;
}