<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PartnerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Partners extends BaseController
{
    protected PartnerModel $model;

    public function __construct()
    {
        $this->model = new PartnerModel();
    }

    public function index()
    {
        $partners = $this->model
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->findAll();

        return view('partners/index', [
            'partners' => $partners,
        ]);
    }

    public function create()
    {
        return view('partners/create');
    }

    public function store()
    {
        $rules = [
            'name'        => 'required|min_length[2]|max_length[150]',
            'logo'        => 'uploaded[logo]|is_image[logo]|max_size[logo,4096]|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]',
            'website_url' => 'permit_empty|max_length[255]|valid_url',
            'sort_order'  => 'permit_empty|is_natural',
            'status'      => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getFormData();
        $upload = $this->request->getFile('logo');

        if ($upload && $upload->isValid() && ! $upload->hasMoved()) {
            $data['logo'] = $this->uploadLogo($upload);
        }

        if (! $this->model->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/partners')
            ->with('success', 'Partner created successfully!');
    }

    public function edit($id)
    {
        $partner = $this->findPartner($id);

        return view('partners/edit', [
            'partner' => $partner,
        ]);
    }

    public function update($id)
    {
        $existing = $this->findPartner($id);

        $rules = [
            'name'        => 'required|min_length[2]|max_length[150]',
            'logo'        => 'permit_empty|is_image[logo]|max_size[logo,4096]|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]',
            'website_url' => 'permit_empty|max_length[255]|valid_url',
            'sort_order'  => 'permit_empty|is_natural',
            'status'      => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = $this->getFormData();
        $upload = $this->request->getFile('logo');
        $deleteCurrentLogo = (bool) $this->request->getPost('delete_current_logo');

        if ($upload && $upload->isValid() && ! $upload->hasMoved()) {
            $data['logo'] = $this->uploadLogo($upload);
            $this->deleteLogoFile($existing['logo'] ?? null);
        } elseif ($deleteCurrentLogo) {
            $this->deleteLogoFile($existing['logo'] ?? null);
            $data['logo'] = null;
        }

        if (! $this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/partners')
            ->with('success', 'Partner updated successfully!');
    }

    public function delete($id)
    {
        $this->findPartner($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/partners')
            ->with('success', 'Partner deleted successfully!');
    }

    private function findPartner($id): array
    {
        $partner = $this->model->find($id);

        if (! $partner) {
            throw new PageNotFoundException('Partner not found');
        }

        return $partner;
    }

    private function getFormData(): array
    {
        $websiteUrl = trim((string) $this->request->getPost('website_url'));

        return [
            'name'        => trim((string) $this->request->getPost('name')),
            'website_url' => $websiteUrl !== '' ? $websiteUrl : null,
            'sort_order'  => $this->request->getPost('sort_order') !== null ? (int) $this->request->getPost('sort_order') : 0,
            'status'      => (int) ($this->request->getPost('status') ?? 1),
        ];
    }

    private function uploadLogo($upload): string
    {
        $uploadPath = FCPATH . 'uploads/partners/';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $newName = $upload->getRandomName();
        $upload->move($uploadPath, $newName);

        return 'uploads/partners/' . $newName;
    }

    private function deleteLogoFile(?string $logo): void
    {
        if (empty($logo)) {
            return;
        }

        $filePath = FCPATH . $logo;
        if (is_file($filePath)) {
            unlink($filePath);
        }
    }
}
