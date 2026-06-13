<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\HotelCategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class HotelCategories extends BaseController
{
    protected HotelCategoryModel $model;

    public function __construct()
    {
        $this->model = new HotelCategoryModel();
        helper('common');
    }

    public function index()
    {
        return view('hotel_categories/index', [
            'hotel_categories' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('hotel_categories/create');
    }

    public function store()
    {
        $rules = [
            'name'   => 'required|min_length[2]|max_length[150]',
            'stars'  => 'required|integer',
            'slug'   => 'permit_empty|is_unique[mst_hotel_categories.slug]|min_length[2]|max_length[180]',
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
            ->to('/hotel_categories')
            ->with('success', 'Hotel category created successfully!');
    }

    public function edit($id)
    {
        $hotelCategory = $this->findHotelCategory($id);

        return view('hotel_categories/edit', [
            'hotel_category' => $hotelCategory,
        ]);
    }

    public function update($id)
    {
        $this->findHotelCategory($id);

        $rules = [
            'name'   => 'required|min_length[2]|max_length[150]',
            'stars'  => 'required|integer',
            'slug'   => 'permit_empty|is_unique[mst_hotel_categories.slug,id,' . $id . ']|min_length[2]|max_length[180]',
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
            ->to('/hotel_categories')
            ->with('success', 'Hotel category updated successfully!');
    }

    public function delete($id)
    {
        $this->findHotelCategory($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/hotel_categories')
            ->with('success', 'Hotel category deleted successfully!');
    }

    private function findHotelCategory($id): array
    {
        $hotelCategory = $this->model->find($id);

        if (! $hotelCategory) {
            throw new PageNotFoundException('Hotel category not found');
        }

        return $hotelCategory;
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
            'stars'       => (int) $this->request->getPost('stars'),
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'icon'        => trim((string) $this->request->getPost('icon')),
            'status'      => $this->request->getPost('status') ?? 1,
        ];
    }
}
