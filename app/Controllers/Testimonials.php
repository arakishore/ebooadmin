<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CmsTestimonialModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Testimonials extends BaseController
{
    protected CmsTestimonialModel $model;

    public function __construct()
    {
        $this->model = new CmsTestimonialModel();
    }

    public function index()
    {
        $testimonials = $this->model
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('testimonial/index', [
            'testimonials' => $testimonials,
        ]);
    }

    public function create()
    {
        return view('testimonial/create');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|min_length[2]|max_length[100]',
            'designation' => 'permit_empty|max_length[150]',
            'company'    => 'permit_empty|max_length[150]',
            'location'   => 'permit_empty|max_length[150]',
            'image'      => 'permit_empty|is_image[image]|max_size[image,4096]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
            'rating'     => 'required|in_list[4,5]',
            'message'    => 'required|min_length[10]',
            'featured'   => 'required|in_list[0,1]',
            'sort_order' => 'permit_empty|is_natural',
            'status'     => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getFormData();

        $upload = $this->request->getFile('image');
        if ($upload && $upload->isValid() && ! $upload->hasMoved()) {
            $originalPath = FCPATH . 'uploads/testimonials/original/';
            if (! is_dir($originalPath)) {
                mkdir($originalPath, 0755, true);
            }

            $newName = $upload->getRandomName();
            $upload->move($originalPath, $newName);
            $data['image'] = 'uploads/testimonials/original/' . $newName;
        }

        if (! $this->model->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/testimonials')
            ->with('success', 'Testimonial created successfully!');
    }

    public function edit($id)
    {
        $testimonial = $this->findTestimonial($id);

        return view('testimonial/edit', [
            'testimonial' => $testimonial,
        ]);
    }

    public function update($id)
    {
        $existing = $this->findTestimonial($id);

        $rules = [
            'name'       => 'required|min_length[2]|max_length[100]',
            'designation' => 'permit_empty|max_length[150]',
            'company'    => 'permit_empty|max_length[150]',
            'location'   => 'permit_empty|max_length[150]',
            'image'      => 'permit_empty|is_image[image]|max_size[image,4096]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
            'rating'     => 'required|in_list[4,5]',
            'message'    => 'required|min_length[10]',
            'featured'   => 'required|in_list[0,1]',
            'sort_order' => 'permit_empty|is_natural',
            'status'     => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getFormData();
        $deleteCurrentImage = (bool) $this->request->getPost('delete_current_image');
        $upload = $this->request->getFile('image');

        if ($upload && $upload->isValid() && ! $upload->hasMoved()) {
            $originalPath = FCPATH . 'uploads/testimonials/original/';
            if (! is_dir($originalPath)) {
                mkdir($originalPath, 0755, true);
            }

            $newName = $upload->getRandomName();
            $upload->move($originalPath, $newName);

            if (! empty($existing['image'])) {
                $filePath = FCPATH . $existing['image'];
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }

            $data['image'] = 'uploads/testimonials/original/' . $newName;
        } elseif ($deleteCurrentImage) {
            if (! empty($existing['image'])) {
                $filePath = FCPATH . $existing['image'];
                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }

            $data['image'] = null;
        }

        if (! $this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/testimonials')
            ->with('success', 'Testimonial updated successfully!');
    }

    public function delete($id)
    {
        $this->findTestimonial($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/testimonials')
            ->with('success', 'Testimonial deleted successfully!');
    }

    private function findTestimonial($id): array
    {
        $testimonial = $this->model->find($id);

        if (! $testimonial) {
            throw new PageNotFoundException('Testimonial not found');
        }

        return $testimonial;
    }

    private function getFormData(): array
    {
        return [
            'name'        => trim((string) $this->request->getPost('name')),
            'designation' => $this->request->getPost('designation') ?: null,
            'company'     => $this->request->getPost('company') ?: null,
            'location'    => $this->request->getPost('location') ?: null,
            'rating'      => (int) ($this->request->getPost('rating') ?? 5),
            'message'     => trim((string) $this->request->getPost('message')),
            'featured'    => (int) ($this->request->getPost('featured') ?? 0),
            'sort_order'  => $this->request->getPost('sort_order') !== null ? (int) $this->request->getPost('sort_order') : 0,
            'status'      => (int) ($this->request->getPost('status') ?? 1),
        ];
    }
}
