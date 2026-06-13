<?php

namespace App\Controllers\Api;

use App\Models\FaqModel;

class Faqs extends BaseApiController
{
    public function index()
    {
        $model = new FaqModel();
        $faqs = $model
            ->select('cms_faqs.id, cms_faqs.question, cms_faqs.answer, cms_faqs.sort_order, cms_faq_categories.name as category')
            ->join('cms_faq_categories', 'cms_faq_categories.id = cms_faqs.category_id', 'left')
            ->where('cms_faqs.status', 1)
            ->orderBy('cms_faq_categories.sort_order', 'ASC')
            ->orderBy('cms_faqs.sort_order', 'ASC')
            ->findAll();

        $data = array_map(fn($faq) => [
            'id' => (int) $faq['id'],
            'question' => $faq['question'],
            'answer' => $faq['answer'],
            'category' => $faq['category'] ?? null,
            'sort_order' => (int) ($faq['sort_order'] ?? 0),
        ], $faqs);

        return $this->success($data);
    }
}
