<?php

namespace App\Controllers\Api;

use App\Models\CmsBannerModel;

class Banners extends BaseApiController
{
    public function index()
    {
        $model = new CmsBannerModel();
        $page = $this->request->getGet('page');

        $query = $model
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC');

        if (! empty($page)) {
            $query->where('page', $page);
        }

        $banners = array_map(function (array $banner) {
            return [
                'id' => (int) $banner['id'],
                'title' => $banner['title'],
                'subtitle' => $banner['subtitle'] ?? null,
                'image' => $this->imageUrl($banner['image'] ?? null),
                'button_text' => $banner['button_text'] ?? null,
                'button_link' => $banner['button_url'] ?? null,
                'page' => $banner['page'] ?? null,
                'sort_order' => (int) ($banner['sort_order'] ?? 0),
            ];
        }, $query->findAll());

        return $this->success($banners);
    }
}
