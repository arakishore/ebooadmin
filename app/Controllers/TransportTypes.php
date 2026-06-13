<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransportTypeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class TransportTypes extends BaseController
{
    protected TransportTypeModel $model;

    public function __construct()
    {
        $this->model = new TransportTypeModel();
        helper('common');
    }

    public function index()
    {
        return view('transport_types/index', [
            'transport_types' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('transport_types/create');
    }

    public function store()
    {
        $rules = [
            'name'   => 'required|min_length[2]|max_length[150]',
            'slug'   => 'permit_empty|is_unique[mst_transport_types.slug]|min_length[2]|max_length[180]',
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
            ->to('/transport_types')
            ->with('success', 'Transport Type created successfully!');
    }

    public function edit($id)
    {
        $transport_type = $this->findTransportType($id);

        return view('transport_types/edit', [
            'transport_type' => $transport_type,
        ]);
    }

    public function update($id)
    {
        $this->findTransportType($id);

        $rules = [
            'name'   => 'required|min_length[2]|max_length[150]',
            'slug'   => 'permit_empty|is_unique[mst_transport_types.slug,id,' . $id . ']|min_length[2]|max_length[180]',
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
            ->to('/transport_types')
            ->with('success', 'Transport Type updated successfully!');
    }

    public function delete($id)
    {
        $this->findTransportType($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/transport_types')
            ->with('success', 'Transport Type deleted successfully!');
    }

    private function findTransportType($id): array
    {
        $transport_type = $this->model->find($id);

        if (! $transport_type) {
            throw new PageNotFoundException('Transport Type not found');
        }

        return $transport_type;
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
