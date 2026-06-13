<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PackageExcludeTypeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PackageExcludeTypes extends BaseController
{
    protected PackageExcludeTypeModel $model;

    public function __construct()
    {
        $this->model = new PackageExcludeTypeModel();
        helper('common');
    }

    public function index()
    {
        return view('package_exclude_types/index', [
            'package_exclude_types' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('package_exclude_types/create');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|min_length[2]|max_length[150]',
            'slug'       => 'permit_empty|is_unique[mst_package_exclude_types.slug]|min_length[2]|max_length[180]',
            'status'     => 'required|in_list[0,1]',
            'sort_order' => 'permit_empty|is_natural',
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
            ->to('/package_exclude_types')
            ->with('success', 'Package exclude type created successfully!');
    }

    public function edit($id)
    {
        $package_exclude_type = $this->findPackageExcludeType($id);

        return view('package_exclude_types/edit', [
            'package_exclude_type' => $package_exclude_type,
        ]);
    }

    public function update($id)
    {
        $this->findPackageExcludeType($id);

        $rules = [
            'name'       => 'required|min_length[2]|max_length[150]',
            'slug'       => 'permit_empty|is_unique[mst_package_exclude_types.slug,id,' . $id . ']|min_length[2]|max_length[180]',
            'status'     => 'required|in_list[0,1]',
            'sort_order' => 'permit_empty|is_natural',
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
            ->to('/package_exclude_types')
            ->with('success', 'Package exclude type updated successfully!');
    }

    public function delete($id)
    {
        $this->findPackageExcludeType($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/package_exclude_types')
            ->with('success', 'Package exclude type deleted successfully!');
    }

    private function findPackageExcludeType($id): array
    {
        $package_exclude_type = $this->model->find($id);

        if (! $package_exclude_type) {
            throw new PageNotFoundException('Package exclude type not found');
        }

        return $package_exclude_type;
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
            'sort_order'  => $this->request->getPost('sort_order') !== null ? (int) $this->request->getPost('sort_order') : 0,
        ];
    }
}
