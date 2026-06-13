<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FaqCategoryModel;
use App\Models\FaqModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Faqs extends BaseController
{
    protected FaqModel $model;
    protected FaqCategoryModel $categoryModel;

    public function __construct()
    {
        $this->model = new FaqModel();
        $this->categoryModel = new FaqCategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->findAll();
        $categoryMap = array_column($categories, 'name', 'id');

        return view('faq/faqs/index', [
            'faqs' => $this->model->findAll(),
            'categoryMap' => $categoryMap,
        ]);
    }

    public function create()
    {
        return view('faq/faqs/create', [
            'categories' => $this->categoryModel->where('status', 1)->orderBy('sort_order', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'question'   => 'required|min_length[5]|max_length[500]',
            'answer'     => 'required|min_length[5]',
            'category_id'=> 'permit_empty|is_natural_no_zero',
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
            ->to('/faqs')
            ->with('success', 'FAQ created successfully!');
    }

    public function edit($id)
    {
        $faq = $this->findFaq($id);

        return view('faq/faqs/edit', [
            'faq' => $faq,
            'categories' => $this->categoryModel->where('status', 1)->orderBy('sort_order', 'ASC')->findAll(),
        ]);
    }

    public function update($id)
    {
        $this->findFaq($id);

        $rules = [
            'question'   => 'required|min_length[5]|max_length[500]',
            'answer'     => 'required|min_length[5]',
            'category_id'=> 'permit_empty|is_natural_no_zero',
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
            ->to('/faqs')
            ->with('success', 'FAQ updated successfully!');
    }

    public function delete($id)
    {
        $this->findFaq($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/faqs')
            ->with('success', 'FAQ deleted successfully!');
    }

    private function findFaq($id): array
    {
        $faq = $this->model->find($id);

        if (! $faq) {
            throw new PageNotFoundException('FAQ not found');
        }

        return $faq;
    }

    private function getFormData(): array
    {
        $categoryId = $this->request->getPost('category_id');

        return [
            'question'    => trim((string) $this->request->getPost('question')),
            'answer'      => trim((string) $this->request->getPost('answer')),
            'category_id' => $categoryId !== null && $categoryId !== '' ? (int) $categoryId : null,
            'status'      => $this->request->getPost('status') ?? 1,
            'sort_order'  => $this->request->getPost('sort_order') !== null ? (int) $this->request->getPost('sort_order') : 0,
        ];
    }
}
