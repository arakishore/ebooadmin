<?php

namespace App\Controllers\Api;

use App\Models\HotelModel;

class Hotels extends BaseApiController
{
    protected HotelModel $hotelModel;

    public function __construct()
    {
        $this->hotelModel = new HotelModel();
    }

    public function search()
    {
        $keyword = trim((string) $this->request->getGet('q'));

        if (strlen($keyword) < 2) {
            return $this->success([]);
        }

        $hotels = $this->hotelModel
            ->select('
                mst_hotels.id,
                mst_hotels.name,
                mst_hotels.sort_order,
                mst_cities.name AS city,
                mst_states.name AS state,
                mst_countries.name AS country,
                mst_hotel_categories.name AS category
            ')
            ->join('mst_cities', 'mst_cities.id = mst_hotels.city_id', 'left')
            ->join('mst_states', 'mst_states.id = mst_hotels.state_id', 'left')
            ->join('mst_countries', 'mst_countries.id = mst_hotels.country_id', 'left')
            ->join('mst_hotel_categories', 'mst_hotel_categories.id = mst_hotels.hotel_category_id', 'left')
            ->where('mst_hotels.status', 1)
            ->where('mst_hotels.deleted_at', null)
            ->groupStart()
                ->like('mst_hotels.name', $keyword)
                ->orLike('mst_cities.name', $keyword)
                ->orLike('mst_states.name', $keyword)
            ->groupEnd()
            ->orderBy('mst_hotels.sort_order', 'ASC')
            ->orderBy('mst_hotels.name', 'ASC')
            ->limit(20)
            ->findAll();

        return $this->success(array_map(fn($hotel) => $this->formatHotel($hotel), $hotels));
    }

    private function formatHotel(array $hotel): array
    {
        $category = $this->formatCategory($hotel['category'] ?? '');
        $label = trim(($hotel['name'] ?? '') . ', ' . ($hotel['city'] ?? ''));

        if ($category !== '') {
            $label .= ' - ' . $category;
        }

        return [
            'id'       => (int) $hotel['id'],
            'name'     => $hotel['name'],
            'city'     => $hotel['city'] ?? null,
            'state'    => $hotel['state'] ?? null,
            'country'  => $hotel['country'] ?? null,
            'category' => $category,
            'label'    => $label,
        ];
    }

    private function formatCategory(string $category): string
    {
        if (preg_match('/^\d+\s+Star$/i', $category)) {
            return $category . ' Hotel';
        }

        return $category;
    }
}
