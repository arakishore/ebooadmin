<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AmenityTypeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AmenityTypes extends BaseController
{
    protected AmenityTypeModel $model;

    public function __construct()
    {
        $this->model = new AmenityTypeModel();
        helper('common');
    }

    public function index()
    {
        return view('amenity_types/index', [
            'amenity_types' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('amenity_types/create');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|min_length[2]|max_length[150]',
            'slug'       => 'permit_empty|is_unique[mst_amenity_types.slug]|min_length[2]|max_length[180]',
            'status'     => 'required|in_list[0,1]',
            'sort_order' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getFormData();

        if (! $this->model->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/amenity_types')
            ->with('success', 'Amenity type created successfully!');
    }

    public function edit($id)
    {
        $amenityType = $this->findAmenityType($id);

        return view('amenity_types/edit', [
            'amenity_type' => $amenityType,
        ]);
    }

    public function update($id)
    {
        $this->findAmenityType($id);

        $rules = [
            'name'       => 'required|min_length[2]|max_length[150]',
            'slug'       => 'permit_empty|is_unique[mst_amenity_types.slug,id,' . $id . ']|min_length[2]|max_length[180]',
            'status'     => 'required|in_list[0,1]',
            'sort_order' => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getFormData();

        if (! $this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/amenity_types')
            ->with('success', 'Amenity type updated successfully!');
    }

    public function delete($id)
    {
        $this->findAmenityType($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/amenity_types')
            ->with('success', 'Amenity type deleted successfully!');
    }

    private function findAmenityType($id): array
    {
        $amenityType = $this->model->find($id);

        if (! $amenityType) {
            throw new PageNotFoundException('Amenity type not found');
        }

        return $amenityType;
    }

    private function getFormData(): array
    {
        $slug = trim((string) $this->request->getPost('slug'));

        if ($slug === '') {
            $slug = generate_slug($this->request->getPost('name'));
        } else {
            $slug = generate_slug($slug);
        }

        return [
            'name'       => trim((string) $this->request->getPost('name')),
            'slug'       => $slug,
            'description'=> $this->request->getPost('description'),
            'icon'       => trim((string) $this->request->getPost('icon')),
            'status'     => $this->request->getPost('status') ?? 1,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
        ];
    }
}
