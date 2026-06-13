<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PackageFactTypeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PackageFactTypes extends BaseController
{
    protected PackageFactTypeModel $model;

    public function __construct()
    {
        $this->model = new PackageFactTypeModel();
        helper('common');
    }

    public function index()
    {
        return view('package_fact_types/index', [
            'package_fact_types' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('package_fact_types/create');
    }

    public function store()
    {
        $rules = [
            'name'   => 'required|min_length[2]|max_length[150]',
            'slug'   => 'permit_empty|is_unique[mst_package_fact_types.slug]|min_length[2]|max_length[180]',
            'status' => 'required|in_list[0,1]',
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
            ->to('/package_fact_types')
            ->with('success', 'Package Fact Type created successfully!');
    }

    public function edit($id)
    {
        $package_fact_type = $this->findPackageFactType($id);

        return view('package_fact_types/edit', [
            'package_fact_type' => $package_fact_type,
        ]);
    }

    public function update($id)
    {
        $this->findPackageFactType($id);

        $rules = [
            'name'   => 'required|min_length[2]|max_length[150]',
            'slug'   => 'permit_empty|is_unique[mst_package_fact_types.slug,id,' . $id . ']|min_length[2]|max_length[180]',
            'status' => 'required|in_list[0,1]',
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
            ->to('/package_fact_types')
            ->with('success', 'Package Fact Type updated successfully!');
    }

    public function delete($id)
    {
        $this->findPackageFactType($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/package_fact_types')
            ->with('success', 'Package Fact Type deleted successfully!');
    }

    private function findPackageFactType($id): array
    {
        $package_fact_type = $this->model->find($id);

        if (! $package_fact_type) {
            throw new PageNotFoundException('Package Fact Type not found');
        }

        return $package_fact_type;
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
            'name'        => trim((string) $this->request->getPost('name')),
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'icon'        => $this->request->getPost('icon'),
            'status'      => $this->request->getPost('status') ?? 1,
            'sort_order'  => $this->request->getPost('sort_order') ?? 0,
        ];
    }
}
