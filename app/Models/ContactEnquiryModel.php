<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactEnquiryModel extends Model
{
    protected $table            = 'contact_enquiries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields    = [
        'enquiry_type',
        'package_id',
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'travel_date',
        'adults',
        'children',
        'hotel_id',
        'hotel_name',
        'check_in',
        'check_out',
        'rooms',
        'pickup_location',
        'dropoff_location',
        'pickup_date',
        'dropoff_date',
        'passengers',
        'vehicle_type',
        'is_air_con',
        'currency_type',
        'currency_amount',
        'status',
        'viewed_at',
        'viewed_by',
        'replied_at',
        'replied_by',
        'reply_message',
        'admin_note',
        'ip_address',
        'user_agent',
        'page_url',
        'referrer_url',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'source',
        'is_archived',
        'archived_at',
        'archived_by',
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

