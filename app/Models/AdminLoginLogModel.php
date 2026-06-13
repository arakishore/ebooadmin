<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminLoginLogModel extends Model
{
    protected $table            = 'admin_login_logs';

    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';

    protected $useSoftDeletes   = false;

    protected $protectFields    = true;

    protected $allowedFields    = [
        'admin_id',
        'email',
        'ip_address',
        'user_agent',
        'login_status',
        'failure_reason',
        'logged_at',
    ];

    protected bool $allowEmptyInserts = false;

    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = false;

    protected $dateFormat = 'datetime';

    protected $validationRules = [

        'login_status' => 'required|in_list[success,failed]',

    ];

    protected $validationMessages = [];

    protected $skipValidation = false;
}