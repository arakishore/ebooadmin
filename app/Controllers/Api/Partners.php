<?php

namespace App\Controllers\Api;

use App\Models\PartnerModel;

class Partners extends BaseApiController
{
    public function index()
    {
        $model = new PartnerModel();
        $partners = $model
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();

        $data = array_map(fn($partner) => [
            'id' => (int) $partner['id'],
            'name' => $partner['name'],
            'logo' => $this->imageUrl($partner['logo'] ?? null),
            'website_url' => $partner['website_url'] ?? null,
            'sort_order' => (int) ($partner['sort_order'] ?? 0),
        ], $partners);

        return $this->success($data);
    }
}
