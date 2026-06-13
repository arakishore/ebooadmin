<?php

namespace App\Controllers\Api;

use App\Models\CityModel;

class Cities extends BaseApiController
{
    protected CityModel $cityModel;

    public function __construct()
    {
        $this->cityModel = new CityModel();
    }

    public function index()
    {
        $countryId = $this->request->getGet('country_id');
        $stateId = $this->request->getGet('state_id');
        $search = trim((string) $this->request->getGet('search'));

        $builder = $this->cityModel->orderBy('name', 'ASC');

        if ($countryId !== null && $countryId !== '') {
            $builder->where('country_id', (int) $countryId);
        }

        if ($stateId !== null && $stateId !== '') {
            $builder->where('state_id', (int) $stateId);
        }

        if ($search !== '') {
            $builder
                ->groupStart()
                ->like('name', $search)
                ->orLike('city_code', $search)
                ->groupEnd();
        }

        $cities = $builder->findAll();

        return $this->success(array_map(fn($city) => $this->formatCity($city), $cities));
    }

    public function byCountry($countryId)
    {
        $cities = $this->cityModel
            ->where('country_id', (int) $countryId)
            ->orderBy('name', 'ASC')
            ->findAll();

        return $this->success(array_map(fn($city) => $this->formatCity($city), $cities));
    }

    public function byState($stateId)
    {
        $cities = $this->cityModel
            ->where('state_id', (int) $stateId)
            ->orderBy('name', 'ASC')
            ->findAll();

        return $this->success(array_map(fn($city) => $this->formatCity($city), $cities));
    }

    public function show($id)
    {
        $city = $this->cityModel
            ->where('id', (int) $id)
            ->first();

        if (! $city) {
            return $this->error('City not found', [], 404);
        }

        return $this->success($this->formatCity($city));
    }

    private function formatCity(array $city): array
    {
        return [
            'id' => (int) $city['id'],
            'name' => $city['name'],
            'city_code' => $city['city_code'] ?? null,
            'state_id' => isset($city['state_id']) ? (int) $city['state_id'] : null,
            'country_id' => isset($city['country_id']) ? (int) $city['country_id'] : null,
        ];
    }
}
