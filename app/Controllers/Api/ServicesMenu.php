<?php

namespace App\Controllers\Api;

use App\Models\ServiceMenuModel;

class ServicesMenu extends BaseApiController
{
    public function index()
    {
        $model = new ServiceMenuModel();
        $partners = $model
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        $data = array_map(fn($partner) => [
            'id' => (int) $partner['id'],
            'name' => $partner['name'],
            'slug' => $partner['slug'],
            'status' => $partner['status'],
            'sort_order' => (int) ($partner['sort_order'] ?? 0),
        ], $partners);

        return $this->success($data);
    }
}
