<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CmsBannerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Banners extends BaseController
{
    protected CmsBannerModel $model;

    public function __construct()
    {
        $this->model = new CmsBannerModel();
        helper('common');
    }

    public function index()
    {
        return view('banner/index', [
            'banners' => $this->model->findAll(),
        ]);
    }

    public function create()
    {
        return view('banner/create');
    }

    public function store()
    {
        $rules = [
            'title' => 'required|min_length[2]|max_length[255]',
            'image' => 'permit_empty|is_image[image]|max_size[image,4096]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
            'status' => 'required|in_list[0,1]',
            'sort_order' => 'permit_empty|is_natural',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getFormData();

        // Handle image upload
        $upload = $this->request->getFile('image');

        if ($upload && $upload->isValid() && ! $upload->hasMoved()) {
            $originalPath = FCPATH . 'uploads/banners/original/';
            $thumbPath = FCPATH . 'uploads/banners/thumb/';

            if (! is_dir($originalPath)) {
                mkdir($originalPath, 0755, true);
            }
            if (! is_dir($thumbPath)) {
                mkdir($thumbPath, 0755, true);
            }

            $newName = $upload->getRandomName();
            $upload->move($originalPath, $newName);

            $imageService = \Config\Services::image();
            $imageService
                ->withFile($originalPath . $newName)
                ->fit(1200, 400, 'center')
                ->save($thumbPath . $newName);

            $data['image'] = 'uploads/banners/original/' . $newName;
        }

        if (! $this->model->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/banners')
            ->with('success', 'Banner created successfully!');
    }

    public function edit($id)
    {
        $banner = $this->findBanner($id);

        return view('banner/edit', [
            'banner' => $banner,
        ]);
    }

    public function update($id)
    {
        $existing = $this->findBanner($id);

        $rules = [
            'title' => 'required|min_length[2]|max_length[255]',
            'image' => 'permit_empty|is_image[image]|max_size[image,4096]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
            'status' => 'required|in_list[0,1]',
            'sort_order' => 'permit_empty|is_natural',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getFormData();

        $upload = $this->request->getFile('image');
        $deleteCurrentImage = (bool) $this->request->getPost('delete_current_image');

        if ($upload && $upload->isValid() && ! $upload->hasMoved()) {
            $originalPath = FCPATH . 'uploads/banners/original/';
            $thumbPath = FCPATH . 'uploads/banners/thumb/';

            if (! is_dir($originalPath)) {
                mkdir($originalPath, 0755, true);
            }
            if (! is_dir($thumbPath)) {
                mkdir($thumbPath, 0755, true);
            }

            $newName = $upload->getRandomName();
            $upload->move($originalPath, $newName);

            $imageService = \Config\Services::image();
            $imageService
                ->withFile($originalPath . $newName)
                ->fit(1200, 400, 'center')
                ->save($thumbPath . $newName);

            $this->removeBannerImage($existing['image'] ?? null);

            $data['image'] = 'uploads/banners/original/' . $newName;
        } elseif ($deleteCurrentImage) {
            $this->removeBannerImage($existing['image'] ?? null);
            $data['image'] = null;
        }

        if (! $this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/banners')
            ->with('success', 'Banner updated successfully!');
    }

    public function delete($id)
    {
        $this->findBanner($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/banners')
            ->with('success', 'Banner deleted successfully!');
    }

    private function findBanner($id): array
    {
        $banner = $this->model->find($id);

        if (! $banner) {
            throw new PageNotFoundException('Banner not found');
        }

        return $banner;
    }

    private function getFormData(): array
    {
        return [
            'title'       => trim((string) $this->request->getPost('title')),
            'subtitle'    => $this->request->getPost('subtitle') ?: null,
            'button_text' => $this->request->getPost('button_text') ?: null,
            'button_url'  => $this->request->getPost('button_url') ?: null,
            'page'        => $this->request->getPost('page') ?: 'home',
            'sort_order'  => $this->request->getPost('sort_order') !== null ? (int) $this->request->getPost('sort_order') : 0,
            'status'      => $this->request->getPost('status') ?? 1,
        ];
    }

    private function removeBannerImage(?string $image): void
    {
        if (empty($image)) {
            return;
        }

        $filePath = FCPATH . $image;
        if (is_file($filePath)) {
            @unlink($filePath);
        }

        if (strpos($image, '/original/') !== false) {
            $thumbPath = FCPATH . str_replace('/original/', '/thumb/', $image);
            if (is_file($thumbPath)) {
                @unlink($thumbPath);
            }
        }
    }
}
