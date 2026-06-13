<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MealPlanTypeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MealPlanTypes extends BaseController
{
    protected MealPlanTypeModel $model;

    public function __construct()
    {
        $this->model = new MealPlanTypeModel();
        helper('common');
    }

    public function index()
    {
        return view('meal_plan_types/index', [
            'meal_plan_types' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('meal_plan_types/create');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|min_length[2]|max_length[150]',
            'slug'       => 'permit_empty|is_unique[mst_meal_plan_types.slug]|min_length[2]|max_length[180]',
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
            ->to('/meal_plan_types')
            ->with('success', 'Meal plan type created successfully!');
    }

    public function edit($id)
    {
        $meal_plan_type = $this->findMealPlanType($id);

        return view('meal_plan_types/edit', [
            'meal_plan_type' => $meal_plan_type,
        ]);
    }

    public function update($id)
    {
        $this->findMealPlanType($id);

        $rules = [
            'name'       => 'required|min_length[2]|max_length[150]',
            'slug'       => 'permit_empty|is_unique[mst_meal_plan_types.slug,id,' . $id . ']|min_length[2]|max_length[180]',
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
            ->to('/meal_plan_types')
            ->with('success', 'Meal plan type updated successfully!');
    }

    public function delete($id)
    {
        $this->findMealPlanType($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/meal_plan_types')
            ->with('success', 'Meal plan type deleted successfully!');
    }

    private function findMealPlanType($id): array
    {
        $meal_plan_type = $this->model->find($id);

        if (! $meal_plan_type) {
            throw new PageNotFoundException('Meal plan type not found');
        }

        return $meal_plan_type;
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
