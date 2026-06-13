<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PackageCategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PackageCategories extends BaseController
{
    protected PackageCategoryModel $model;

    public function __construct()
    {
        $this->model = new PackageCategoryModel();
        helper('common');
    }

    public function index()
    {
        return view('package_categories/index', [
            'package_categories' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('package_categories/create');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|min_length[2]|max_length[150]',
            'slug'       => 'permit_empty|is_unique[mst_package_categories.slug]|min_length[2]|max_length[180]',
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
            ->to('/package_categories')
            ->with('success', 'Package category created successfully!');
    }

    public function edit($id)
    {
        $package_category = $this->findPackageCategory($id);

        return view('package_categories/edit', [
            'package_category' => $package_category,
        ]);
    }

    public function update($id)
    {
        $this->findPackageCategory($id);

        $rules = [
            'name'       => 'required|min_length[2]|max_length[150]',
            'slug'       => 'permit_empty|is_unique[mst_package_categories.slug,id,' . $id . ']|min_length[2]|max_length[180]',
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
            ->to('/package_categories')
            ->with('success', 'Package category updated successfully!');
    }

    public function delete($id)
    {
        $this->findPackageCategory($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/package_categories')
            ->with('success', 'Package category deleted successfully!');
    }

    private function findPackageCategory($id): array
    {
        $package_category = $this->model->find($id);

        if (! $package_category) {
            throw new PageNotFoundException('Package category not found');
        }

        return $package_category;
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
            'status'      => $this->request->getPost('status') ?? 1,
            'sort_order'  => $this->request->getPost('sort_order') !== null ? (int) $this->request->getPost('sort_order') : 0,
        ];
    }
}
