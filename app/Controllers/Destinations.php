<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DestinationImageModel;
use App\Models\DestinationModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Destinations extends BaseController
{
    protected DestinationModel $model;
    protected DestinationImageModel $destinationImageModel;

    public function __construct()
    {
        $this->model = new DestinationModel();
        $this->destinationImageModel = new DestinationImageModel();
        helper('common');
    }

    public function index()
    {
        return view('destinations/index', [
            'destinations' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('destinations/create');
    }

    public function store()
    {
        $rules = [
            'name'         => 'required|min_length[2]|max_length[150]',
            'slug'         => 'permit_empty|is_unique[mst_destinations.slug]|min_length[2]|max_length[180]',
            'image'        => 'permit_empty|is_image[image]|max_size[image,4096]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
            'banner_image' => 'permit_empty|is_image[banner_image]|max_size[banner_image,4096]|mime_in[banner_image,image/jpg,image/jpeg,image/png,image/webp]',
            'sort_order'   => 'permit_empty|is_natural',
            'status'       => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getFormData();
        $image = $this->request->getFile('image');
        $bannerImage = $this->request->getFile('banner_image');

        $insertId = $this->model->insert($data);

        if (! $insertId) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        $mediaData = [];

        if ($image && $image->isValid() && ! $image->hasMoved()) {
            $mediaData['image'] = $this->uploadDestinationImage((int) $insertId, $image);
        }

        if ($bannerImage && $bannerImage->isValid() && ! $bannerImage->hasMoved()) {
            $mediaData['banner_image'] = $this->uploadDestinationImage((int) $insertId, $bannerImage, 'banner');
        }

        if (! empty($mediaData) && ! $this->model->update($insertId, $mediaData)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/destinations')
            ->with('success', 'Destination created successfully!');
    }

    public function edit($id)
    {
        $destination = $this->findDestination($id);

        return view('destinations/edit', [
            'destination' => $destination,
            'destinationImages' => $this->getDestinationImages($id),
        ]);
    }

    public function uploadImage($destinationId)
    {
        $this->findDestination($destinationId);

        $rules = [
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

        $upload = $this->request->getFile('image');

        if (! $upload->isValid()) {
            return $this->response->setStatusCode(422)
                ->setJSON([
                    'success' => false,
                    'errors' => ['image' => $upload->getErrorString()],
                    'csrfHash' => csrf_hash(),
                ]);
        }

        $originalPath = FCPATH . 'uploads/destinations/' . $destinationId . '/gallery/original/';
        $thumbPath = FCPATH . 'uploads/destinations/' . $destinationId . '/gallery/thumb/';

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

        $relativePath = 'uploads/destinations/' . $destinationId . '/gallery/original/' . $newName;
        $lastOrder = $this->destinationImageModel
            ->selectMax('sort_order')
            ->where('destination_id', $destinationId)
            ->first();

        $sortOrder = 1;

        if (! empty($lastOrder) && isset($lastOrder['sort_order'])) {
            $sortOrder = ((int) $lastOrder['sort_order']) + 1;
        }

        $insertId = $this->destinationImageModel->insert([
            'destination_id' => (int) $destinationId,
            'image' => $relativePath,
            'title' => null,
            'sort_order' => $sortOrder,
            'status' => 1,
        ]);

        if (! $insertId) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'errors' => $this->destinationImageModel->errors(),
                    'csrfHash' => csrf_hash(),
                ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'id' => $insertId,
                'image' => $relativePath,
                'url' => base_url($relativePath),
            ],
            'csrfHash' => csrf_hash(),
        ]);
    }

    public function deleteImage($imageId)
    {
        $destinationImage = $this->findDestinationImage($imageId);
        $this->deleteGalleryImageFile($destinationImage['image'] ?? null);

        if (! $this->destinationImageModel->delete($imageId)) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'errors' => $this->destinationImageModel->errors(),
                    'csrfHash' => csrf_hash(),
                ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'csrfHash' => csrf_hash(),
        ]);
    }

    public function update($id)
    {
        $existing = $this->findDestination($id);

        $rules = [
            'name'         => 'required|min_length[2]|max_length[150]',
            'slug'         => 'permit_empty|is_unique[mst_destinations.slug,id,' . $id . ']|min_length[2]|max_length[180]',
            'image'        => 'permit_empty|is_image[image]|max_size[image,4096]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
            'banner_image' => 'permit_empty|is_image[banner_image]|max_size[banner_image,4096]|mime_in[banner_image,image/jpg,image/jpeg,image/png,image/webp]',
            'sort_order'   => 'permit_empty|is_natural',
            'status'       => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getFormData();
        $image = $this->request->getFile('image');
        $bannerImage = $this->request->getFile('banner_image');
        $deleteCurrentImage = (bool) $this->request->getPost('delete_current_image');
        $deleteCurrentBannerImage = (bool) $this->request->getPost('delete_current_banner_image');

        if ($image && $image->isValid() && ! $image->hasMoved()) {
            $data['image'] = $this->uploadDestinationImage((int) $id, $image);
            $this->deleteImageFile($existing['image'] ?? null);
        } elseif ($deleteCurrentImage) {
            $this->deleteImageFile($existing['image'] ?? null);
            $data['image'] = null;
        }

        if ($bannerImage && $bannerImage->isValid() && ! $bannerImage->hasMoved()) {
            $data['banner_image'] = $this->uploadDestinationImage((int) $id, $bannerImage, 'banner');
            $this->deleteImageFile($existing['banner_image'] ?? null);
        } elseif ($deleteCurrentBannerImage) {
            $this->deleteImageFile($existing['banner_image'] ?? null);
            $data['banner_image'] = null;
        }

        if (! $this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/destinations')
            ->with('success', 'Destination updated successfully!');
    }

    public function delete($id)
    {
        $this->findDestination($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/destinations')
            ->with('success', 'Destination deleted successfully!');
    }

    private function findDestination($id): array
    {
        $destination = $this->model->find($id);

        if (! $destination) {
            throw new PageNotFoundException('Destination not found');
        }

        return $destination;
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
            'country'     => $this->request->getPost('country'),
            'city'        => $this->request->getPost('city'),
            'sort_order'  => $this->request->getPost('sort_order') !== null ? (int) $this->request->getPost('sort_order') : 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ];
    }

    private function uploadDestinationImage(int $destinationId, $upload, string $type = 'image'): string
    {
        $relativeDirectory = 'uploads/destinations/' . $destinationId . '/';

        if ($type === 'banner') {
            $relativeDirectory .= 'banner/';
        }

        $uploadPath = FCPATH . $relativeDirectory;

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $newName = $upload->getRandomName();
        $upload->move($uploadPath, $newName);

        return $relativeDirectory . $newName;
    }

    private function deleteImageFile(?string $image): void
    {
        if (empty($image)) {
            return;
        }

        $filePath = FCPATH . $image;
        if (is_file($filePath)) {
            unlink($filePath);
        }
    }

    private function getDestinationImages($destinationId): array
    {
        return $this->destinationImageModel
            ->where('destination_id', $destinationId)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    private function findDestinationImage($id): array
    {
        $image = $this->destinationImageModel->find($id);

        if (! $image) {
            throw new PageNotFoundException('Destination image not found');
        }

        return $image;
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

        if (strpos($image, '/gallery/original/') !== false) {
            $thumbPath = FCPATH . str_replace('/gallery/original/', '/gallery/thumb/', $image);
            if (is_file($thumbPath)) {
                @unlink($thumbPath);
            }
        }
    }
}
