<?php

namespace App\Controllers\Api;

use App\Models\CountryModel;

class Countries extends BaseApiController
{
    protected CountryModel $countryModel;

    public function __construct()
    {
        $this->countryModel = new CountryModel();
    }

    public function index()
    {
        $search = trim((string) $this->request->getGet('search'));

        $builder = $this->countryModel
            ->where('status', 1)
            ->orderBy('name', 'ASC');

        if ($search !== '') {
            $builder
                ->groupStart()
                ->like('name', $search)
                ->orLike('iso2', $search)
                ->orLike('iso3', $search)
                ->orLike('phonecode', $search)
                ->groupEnd();
        }

        $countries = $builder->findAll();

        return $this->success(array_map(fn($country) => $this->formatCountry($country), $countries));
    }

    public function show($identifier)
    {
        $builder = $this->countryModel->where('status', 1);

        if (ctype_digit((string) $identifier)) {
            $country = $builder->where('id', (int) $identifier)->first();
        } else {
            $identifier = strtoupper((string) $identifier);
            $country = $builder
                ->groupStart()
                ->where('iso2', $identifier)
                ->orWhere('iso3', $identifier)
                ->groupEnd()
                ->first();
        }

        if (! $country) {
            return $this->error('Country not found', [], 404);
        }

        return $this->success($this->formatCountry($country));
    }

    private function formatCountry(array $country): array
    {
        return [
            'id' => (int) $country['id'],
            'name' => $country['name'],
            'iso3' => $country['iso3'] ?? null,
            'numeric_code' => $country['numeric_code'] ?? null,
            'iso2' => $country['iso2'] ?? null,
            'phonecode' => $country['phonecode'] ?? null,
            'capital' => $country['capital'] ?? null,
            'currency' => $country['currency'] ?? null,
            'currency_name' => $country['currency_name'] ?? null,
            'currency_symbol' => $country['currency_symbol'] ?? null,
            'region_id' => isset($country['region_id']) ? (int) $country['region_id'] : null,
            'subregion_id' => isset($country['subregion_id']) ? (int) $country['subregion_id'] : null,
            'nationality' => $country['nationality'] ?? null,
        ];
    }
}
