<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ActivityTypeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ActivityTypes extends BaseController
{
    protected ActivityTypeModel $model;

    public function __construct()
    {
        $this->model = new ActivityTypeModel();
        helper('common');
    }

    public function index()
    {
        return view('activity_types/index', [
            'activity_types' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('activity_types/create');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|min_length[2]|max_length[150]',
            'slug'       => 'permit_empty|is_unique[mst_activity_types.slug]|min_length[2]|max_length[180]',
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
            ->to('/activity_types')
            ->with('success', 'Activity type created successfully!');
    }

    public function edit($id)
    {
        $activityType = $this->findActivityType($id);

        return view('activity_types/edit', [
            'activity_type' => $activityType,
        ]);
    }

    public function update($id)
    {
        $this->findActivityType($id);

        $rules = [
            'name'       => 'required|min_length[2]|max_length[150]',
            'slug'       => 'permit_empty|is_unique[mst_activity_types.slug,id,' . $id . ']|min_length[2]|max_length[180]',
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
            ->to('/activity_types')
            ->with('success', 'Activity type updated successfully!');
    }

    public function delete($id)
    {
        $this->findActivityType($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/activity_types')
            ->with('success', 'Activity type deleted successfully!');
    }

    private function findActivityType($id): array
    {
        $activityType = $this->model->find($id);

        if (! $activityType) {
            throw new PageNotFoundException('Activity type not found');
        }

        return $activityType;
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
            'icon'       => trim((string) $this->request->getPost('icon')),
            'status'     => $this->request->getPost('status') ?? 1,
            'sort_order' => $this->request->getPost('sort_order') ?? 0,
        ];
    }
}
