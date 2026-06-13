<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PackageIncludeTypeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PackageIncludeTypes extends BaseController
{
    protected PackageIncludeTypeModel $model;

    public function __construct()
    {
        $this->model = new PackageIncludeTypeModel();
        helper('common');
    }

    public function index()
    {
        return view('package_include_types/index', [
            'package_include_types' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('package_include_types/create');
    }

    public function store()
    {
        $rules = [
            'name'   => 'required|min_length[2]|max_length[150]',
            'slug'   => 'permit_empty|is_unique[mst_package_include_types.slug]|min_length[2]|max_length[180]',
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
            ->to('/package_include_types')
            ->with('success', 'Package Include Type created successfully!');
    }

    public function edit($id)
    {
        $package_include_type = $this->findPackageIncludeType($id);

        return view('package_include_types/edit', [
            'package_include_type' => $package_include_type,
        ]);
    }

    public function update($id)
    {
        $this->findPackageIncludeType($id);

        $rules = [
            'name'   => 'required|min_length[2]|max_length[150]',
            'slug'   => 'permit_empty|is_unique[mst_package_include_types.slug,id,' . $id . ']|min_length[2]|max_length[180]',
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
            ->to('/package_include_types')
            ->with('success', 'Package Include Type updated successfully!');
    }

    public function delete($id)
    {
        $this->findPackageIncludeType($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/package_include_types')
            ->with('success', 'Package Include Type deleted successfully!');
    }

    private function findPackageIncludeType($id): array
    {
        $package_include_type = $this->model->find($id);

        if (! $package_include_type) {
            throw new PageNotFoundException('Package Include Type not found');
        }

        return $package_include_type;
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
