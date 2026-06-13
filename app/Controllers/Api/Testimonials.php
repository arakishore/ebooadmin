<?php

namespace App\Controllers\Api;

use App\Models\CmsTestimonialModel;

class Testimonials extends BaseApiController
{
    public function index()
    {
        $model = new CmsTestimonialModel();
        $testimonials = $model
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        $data = array_map(fn($testimonial) => [
            'id' => (int) $testimonial['id'],
            'name' => $testimonial['name'],
            'designation' => $testimonial['designation'] ?? null,
            'company' => $testimonial['company'] ?? null,
            'location' => $testimonial['location'] ?? null,
            'image' => $this->imageUrl($testimonial['image'] ?? null),
            'rating' => (int) ($testimonial['rating'] ?? 5),
            'message' => $testimonial['message'] ?? null,
            'featured' => (bool) ($testimonial['featured'] ?? false),
            'sort_order' => (int) ($testimonial['sort_order'] ?? 0),
        ], $testimonials);

        return $this->success($data);
    }
}
