<?php

namespace App\Controllers\Api;

use App\Models\StateModel;

class States extends BaseApiController
{
    protected StateModel $stateModel;

    public function __construct()
    {
        $this->stateModel = new StateModel();
    }

    public function index()
    {
        $countryId = $this->request->getGet('country_id');
        $countryCode = trim((string) $this->request->getGet('country_code'));
        $search = trim((string) $this->request->getGet('search'));

        $builder = $this->stateModel
            ->where('status', 1)
            ->orderBy('name', 'ASC');

        if ($countryId !== null && $countryId !== '') {
            $builder->where('country_id', (int) $countryId);
        }

        if ($countryCode !== '') {
            $builder->where('country_code', strtoupper($countryCode));
        }

        if ($search !== '') {
            $builder
                ->groupStart()
                ->like('name', $search)
                ->orLike('iso2', $search)
                ->orLike('iso3166_2', $search)
                ->groupEnd();
        }

        $states = $builder->findAll();

        return $this->success(array_map(fn($state) => $this->formatState($state), $states));
    }

    public function byCountry($countryId)
    {
        $states = $this->stateModel
            ->where('status', 1)
            ->where('country_id', (int) $countryId)
            ->orderBy('name', 'ASC')
            ->findAll();

        return $this->success(array_map(fn($state) => $this->formatState($state), $states));
    }

    public function show($id)
    {
        $state = $this->stateModel
            ->where('status', 1)
            ->where('id', (int) $id)
            ->first();

        if (! $state) {
            return $this->error('State not found', [], 404);
        }

        return $this->success($this->formatState($state));
    }

    private function formatState(array $state): array
    {
        return [
            'id' => (int) $state['id'],
            'name' => $state['name'],
            'country_id' => isset($state['country_id']) ? (int) $state['country_id'] : null,
            'country_code' => $state['country_code'] ?? null,
            'iso2' => $state['iso2'] ?? null,
            'iso3166_2' => $state['iso3166_2'] ?? null,
        ];
    }
}
