<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GalleryImageModel;

class Gallery extends BaseController
{
    private const GALLERY_TYPES = [
        'hotel'   => 'Hotel',
        'car'     => 'Car',
        'cruise'  => 'Cruise',
        'flight'  => 'Flight',
        'visa'    => 'Visa',
        'forex'   => 'Forex',
    ];

    protected GalleryImageModel $galleryImageModel;

    public function __construct()
    {
        $this->galleryImageModel = new GalleryImageModel();
    }

    public function index()
    {
        $galleryType = (string) ($this->request->getGet('gallery_type') ?? 'all');

        if ($galleryType !== 'all' && ! array_key_exists($galleryType, self::GALLERY_TYPES)) {
            $galleryType = 'all';
        }

        $query = $this->galleryImageModel
            ->where('status', 1)
            ->orderBy("FIELD(gallery_type, '" . implode("','", array_keys(self::GALLERY_TYPES)) . "')", '', false)
            ->orderBy('id', 'DESC');

        if ($galleryType !== 'all') {
            $query->where('gallery_type', $galleryType);
        }

        return view('gallery/index', [
            'galleryTypes' => self::GALLERY_TYPES,
            'selectedType' => $galleryType,
            'galleryImages' => $query->findAll(),
        ]);
    }

    public function uploadImage()
    {
        $rules = [
            'gallery_type' => 'required|in_list[' . implode(',', array_keys(self::GALLERY_TYPES)) . ']',
            'image' => 'uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setStatusCode(422)
                ->setJSON([
                    'success' => false,
                    'errors' => $this->validator->getErrors(),
                    'csrfHash' => csrf_hash(),
                ]);
        }

        $galleryType = (string) $this->request->getPost('gallery_type');
        $upload = $this->request->getFile('image');

        if (! $upload || ! $upload->isValid()) {
            return $this->response->setStatusCode(422)
                ->setJSON([
                    'success' => false,
                    'errors' => ['image' => $upload ? $upload->getErrorString() : 'Image is required.'],
                    'csrfHash' => csrf_hash(),
                ]);
        }

        $originalPath = FCPATH . 'uploads/gallery/' . $galleryType . '/original/';
        $thumbPath = FCPATH . 'uploads/gallery/' . $galleryType . '/thumb/';

        if (! is_dir($originalPath)) {
            mkdir($originalPath, 0755, true);
        }
        if (! is_dir($thumbPath)) {
            mkdir($thumbPath, 0755, true);
        }

        $newName = $upload->getRandomName();
        $upload->move($originalPath, $newName);

        \Config\Services::image()
            ->withFile($originalPath . $newName)
            ->fit(400, 300, 'center')
            ->save($thumbPath . $newName);

        $relativePath = 'uploads/gallery/' . $galleryType . '/original/' . $newName;
        $insertId = $this->galleryImageModel->insert([
            'gallery_type' => $galleryType,
            'image' => $relativePath,
            'status' => 1,
        ]);

        if (! $insertId) {
            $this->deleteGalleryImageFile($relativePath);

            return $this->response->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'errors' => $this->galleryImageModel->errors(),
                    'csrfHash' => csrf_hash(),
                ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'id' => $insertId,
                'image' => $relativePath,
                'url' => base_url($relativePath),
                'gallery_type' => $galleryType,
                'gallery_type_label' => self::GALLERY_TYPES[$galleryType],
            ],
            'csrfHash' => csrf_hash(),
        ]);
    }

    public function deleteImage($imageId)
    {
        $galleryImage = $this->galleryImageModel->find($imageId);

        if (! $galleryImage) {
            return $this->response->setStatusCode(404)
                ->setJSON([
                    'success' => false,
                    'errors' => ['image' => 'Gallery image not found.'],
                    'csrfHash' => csrf_hash(),
                ]);
        }

        $this->deleteGalleryImageFile($galleryImage['image'] ?? null);

        if (! $this->galleryImageModel->delete($imageId)) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'errors' => $this->galleryImageModel->errors(),
                    'csrfHash' => csrf_hash(),
                ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'csrfHash' => csrf_hash(),
        ]);
    }

    private function deleteGalleryImageFile(?string $image): void
    {
        if (empty($image)) {
            return;
        }

        $absolutePath = FCPATH . $image;

        if (is_file($absolutePath)) {
            @unlink($absolutePath);
        }

        if (strpos($image, '/original/') !== false) {
            $thumbPath = FCPATH . str_replace('/original/', '/thumb/', $image);
            if (is_file($thumbPath)) {
                @unlink($thumbPath);
            }
        }
    }
}
