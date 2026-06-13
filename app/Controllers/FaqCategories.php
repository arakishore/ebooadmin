<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FaqCategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class FaqCategories extends BaseController
{
    protected FaqCategoryModel $model;

    public function __construct()
    {
        $this->model = new FaqCategoryModel();
        helper('common');
    }

    public function index()
    {
        return view('faq/categories/index', [
            'faqCategories' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('faq/categories/create');
    }

    public function store()
    {
        $rules = [
            'name'       => 'required|min_length[2]|max_length[255]',
            'slug'       => 'permit_empty|is_unique[cms_faq_categories.slug]|min_length[2]|max_length[255]',
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
            ->to('/faq-categories')
            ->with('success', 'FAQ category created successfully!');
    }

    public function edit($id)
    {
        $faqCategory = $this->findFaqCategory($id);

        return view('faq/categories/edit', [
            'faqCategory' => $faqCategory,
        ]);
    }

    public function update($id)
    {
        $this->findFaqCategory($id);

        $rules = [
            'name'       => 'required|min_length[2]|max_length[255]',
            'slug'       => 'permit_empty|is_unique[cms_faq_categories.slug,id,' . $id . ']|min_length[2]|max_length[255]',
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
            ->to('/faq-categories')
            ->with('success', 'FAQ category updated successfully!');
    }

    public function delete($id)
    {
        $this->findFaqCategory($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/faq-categories')
            ->with('success', 'FAQ category deleted successfully!');
    }

    private function findFaqCategory($id): array
    {
        $faqCategory = $this->model->find($id);

        if (! $faqCategory) {
            throw new PageNotFoundException('FAQ category not found');
        }

        return $faqCategory;
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
            'status'     => $this->request->getPost('status') ?? 1,
            'sort_order' => $this->request->getPost('sort_order') !== null ? (int) $this->request->getPost('sort_order') : 0,
        ];
    }
}
