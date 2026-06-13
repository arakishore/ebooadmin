<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DestinationModel;
use App\Models\HotelCategoryModel;
use App\Models\MealPlanTypeModel;
use App\Models\PackageCategoryModel;
use App\Models\PackageCategoryRelationModel;
use App\Models\PackageFactModel;
use App\Models\PackageFactTypeModel;
use App\Models\PackageExcludeModel;
use App\Models\PackageExcludeTypeModel;
use App\Models\PackageImageModel;
use App\Models\PackageIncludeModel;
use App\Models\PackageIncludeTypeModel;
use App\Models\PackageItineraryModel;
use App\Models\PackageModel;
use App\Models\TransportTypeModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Packages extends BaseController
{
    protected PackageModel $model;
    protected DestinationModel $destinationModel;
    protected PackageCategoryModel $packageCategoryModel;
    protected PackageCategoryRelationModel $packageCategoryRelationModel;
    protected HotelCategoryModel $hotelCategoryModel;
    protected MealPlanTypeModel $mealPlanTypeModel;
    protected TransportTypeModel $transportTypeModel;
    protected PackageFactModel $packageFactModel;
    protected PackageFactTypeModel $packageFactTypeModel;
    protected PackageIncludeModel $packageIncludeModel;
    protected PackageIncludeTypeModel $packageIncludeTypeModel;
    protected PackageExcludeModel $packageExcludeModel;
    protected PackageExcludeTypeModel $packageExcludeTypeModel;
    protected PackageImageModel $packageImageModel;
    protected PackageItineraryModel $packageItineraryModel;

    public function __construct()
    {
        $this->model = new PackageModel();
        $this->destinationModel = new DestinationModel();
        $this->packageCategoryModel = new PackageCategoryModel();
        $this->packageCategoryRelationModel = new PackageCategoryRelationModel();
        $this->hotelCategoryModel = new HotelCategoryModel();
        $this->mealPlanTypeModel = new MealPlanTypeModel();
        $this->transportTypeModel = new TransportTypeModel();
        $this->packageFactModel = new PackageFactModel();
        $this->packageFactTypeModel = new PackageFactTypeModel();
        $this->packageIncludeModel = new PackageIncludeModel();
        $this->packageIncludeTypeModel = new PackageIncludeTypeModel();
        $this->packageExcludeModel = new PackageExcludeModel();
        $this->packageExcludeTypeModel = new PackageExcludeTypeModel();
        $this->packageImageModel = new PackageImageModel();
        $this->packageItineraryModel = new PackageItineraryModel();
        helper('common');
    }

    public function index()
    {
        $packages = $this->model->findAll();
        $optionMaps = $this->getOptionMaps();
        $packageCategoryMap = $this->getPackageCategoryNamesByPackage($packages);

        return view('packages/index', array_merge([
            'packages' => $packages,
            'packageCategoryMap' => $packageCategoryMap,
        ], $optionMaps));
    }

    public function create()
    {
        return view('packages/create', $this->getFormOptions());
    }

    public function store()
    {
        $rules = [
            'destination_id'      => 'required|numeric',
            'package_category_ids' => 'required',
            'hotel_category_id'   => 'required|numeric',
            'meal_plan_type_id'   => 'required|numeric',
            'transport_type_id'   => 'required|numeric',

            'title'               => 'required|min_length[2]|max_length[255]',

            'slug'                => 'permit_empty|min_length[2]|max_length[255]|is_unique[t_packages.slug,id,{id}]',

            'short_description'   => 'permit_empty|max_length[1000]',

            'description'         => 'permit_empty',

            'duration_days'   => 'required|is_natural_no_zero', // 1,2,3...
            'duration_nights' => 'required|is_natural',         // 0,1,2...

            'starting_price'      => 'required|decimal',

            'sale_price'          => 'permit_empty|decimal',

            'is_featured'         => 'required|in_list[0,1]',

            'status'              => 'required|in_list[0,1]',

            'sort_order'          => 'permit_empty|numeric',

            'meta_title'          => 'permit_empty|max_length[255]',

            'meta_keywords'       => 'permit_empty|max_length[1000]',

            'meta_description'    => 'permit_empty|max_length[1000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $selectedCategoryIds = $this->getSelectedPackageCategoryIds();
        if (empty($selectedCategoryIds)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', [
                    'package_category_ids' => 'Please select at least one package category.',
                ]);
        }

        $data = $this->getFormData();

        $insertId = $this->model->insert($data);

        if (! $insertId) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        $this->syncPackageCategories((int) $insertId, $selectedCategoryIds);

        return redirect()
            ->to('/packages/edit/' . $insertId)
            ->with('success', 'Package created successfully!');
    }

    public function edit($id)
    {
        $package = $this->findPackage($id);

        return view('packages/edit', array_merge(
            [
                'package' => $package,
                'selectedPackageCategoryIds' => $this->getSelectedPackageCategoryIdsForPackage($id, $package),
                'packageFacts' => $this->getPackageFacts($id),
                'packageItineraries' => $this->getPackageItineraries($id),
                'packageIncludeTypes' => $this->getPackageIncludeTypes(),
                'selectedPackageIncludeTypeIds' => $this->getPackageIncludeTypeIds($id),
                'packageExcludeTypes' => $this->getPackageExcludeTypes(),
                'selectedPackageExcludeTypeIds' => $this->getPackageExcludeTypeIds($id),
                'packageImages' => $this->getPackageImages($id),
            ],
            $this->getFormOptions()
        ));
    }

    public function storeFact($packageId)
    {
        $this->findPackage($packageId);

        $factId = (int) $this->request->getPost('fact_id');
        $packageFactTypeId = (int) $this->request->getPost('package_fact_type_id');

        $rules = [
            'package_fact_type_id' => 'required|numeric',
            'value'                => 'required|max_length[255]',
            'sort_order'           => 'permit_empty|numeric',
            'status'               => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        if ($factId > 0) {
            $existingFact = $this->findPackageFact($factId);

            if ((int) $existingFact['package_id'] !== (int) $packageId) {
                throw new PageNotFoundException('Package fact not found for this package');
            }
        }

        $duplicateQuery = $this->packageFactModel
            ->where('package_id', (int) $packageId)
            ->where('package_fact_type_id', $packageFactTypeId);

        if ($factId > 0) {
            $duplicateQuery->where('id !=', $factId);
        }

        $duplicate = $duplicateQuery->first();

        if ($duplicate) {
            return redirect()->back()
                ->withInput()
                ->with('errors', [
                    'package_fact_type_id' => 'This fact type is already added to this package.',
                ]);
        }

        $data = [
            'package_id'           => (int) $packageId,
            'package_fact_type_id' => $packageFactTypeId,
            'value'                => trim((string) $this->request->getPost('value')),
            'sort_order'           => (int) ($this->request->getPost('sort_order') ?? 0),
            'status'               => (int) $this->request->getPost('status'),
        ];

        if ($factId > 0) {
            if (! $this->packageFactModel->update($factId, $data)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', $this->packageFactModel->errors());
            }

            return redirect()
                ->to('/packages/edit/' . $packageId . '#facts')
                ->with('success', 'Package fact updated successfully!');
        }

        if (! $this->packageFactModel->insert($data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->packageFactModel->errors());
        }

        return redirect()
            ->to('/packages/edit/' . $packageId . '#facts')
            ->with('success', 'Package fact added successfully!');
    }

    public function deleteFact($id)
    {
        $packageFact = $this->findPackageFact($id);

        if (! $this->packageFactModel->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->packageFactModel->errors());
        }

        return redirect()
            ->to('/packages/edit/' . $packageFact['package_id'] . '#facts')
            ->with('success', 'Package fact deleted successfully!');
    }

    public function storeItinerary($packageId)
    {
        $package = $this->findPackage($packageId);

        $dayNumber = (int) $this->request->getPost('day_number');
        $rules = [
            'day_number'      => 'required|numeric',
            'title'           => 'required|max_length[255]',
            'description'     => 'permit_empty',
            'meals'           => 'permit_empty|max_length[255]',
            'overnight_stay'  => 'permit_empty|max_length[255]',
            'sort_order'      => 'permit_empty|numeric',
            'status'          => 'required|in_list[0,1]',
        ];

        if (! $this->validate($rules)) {
            return redirect()
                ->to('/packages/edit/' . $packageId . '#itinerary')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        if ($dayNumber < 1 || $dayNumber > (int) $package['duration_days']) {
            return redirect()
                ->to('/packages/edit/' . $packageId . '#itinerary')
                ->withInput()
                ->with('errors', [
                    'day_number' => 'Invalid itinerary day for this package.',
                ]);
        }

        $existingItinerary = $this->packageItineraryModel
            ->where('package_id', $packageId)
            ->where('day_number', $dayNumber)
            ->first();

        $data = [
            'package_id'      => (int) $packageId,
            'day_number'      => $dayNumber,
            'title'           => trim((string) $this->request->getPost('title')),
            'description'     => $this->request->getPost('description'),
            'meals'           => $this->request->getPost('meals'),
            'overnight_stay'  => $this->request->getPost('overnight_stay'),
            'sort_order'      => (int) ($this->request->getPost('sort_order') ?? 0),
            'status'          => (int) $this->request->getPost('status'),
        ];

        if ($existingItinerary) {
            if (! $this->packageItineraryModel->update($existingItinerary['id'], $data)) {
                return redirect()
                    ->to('/packages/edit/' . $packageId . '#itinerary')
                    ->withInput()
                    ->with('errors', $this->packageItineraryModel->errors());
            }

            return redirect()
                ->to('/packages/edit/' . $packageId . '#itinerary')
                ->with('success', 'Package itinerary updated successfully!');
        }

        if (! $this->packageItineraryModel->insert($data)) {
            return redirect()
                ->to('/packages/edit/' . $packageId . '#itinerary')
                ->withInput()
                ->with('errors', $this->packageItineraryModel->errors());
        }

        return redirect()
            ->to('/packages/edit/' . $packageId . '#itinerary')
            ->with('success', 'Package itinerary saved successfully!');
    }

    public function deleteItinerary($id)
    {
        $packageItinerary = $this->findPackageItinerary($id);

        if (! $this->packageItineraryModel->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->packageItineraryModel->errors());
        }

        return redirect()
            ->to('/packages/edit/' . $packageItinerary['package_id'] . '#itinerary')
            ->with('success', 'Package itinerary deleted successfully!');
    }

    public function storeInclusions($packageId)
    {
        $this->findPackage($packageId);

        $selected = $this->request->getPost('package_include_type_ids');
        $selected = is_array($selected) ? array_values($selected) : [];
        $selected = array_filter($selected, fn($value) => $value !== null && $value !== '');

        $selected = array_map('intval', $selected);
        $selected = array_values(array_unique($selected));

        $activeIncludeTypes = array_map('intval', array_column($this->getPackageIncludeTypes(), 'id'));

        $selected = array_values(array_filter($selected, function ($item) use ($activeIncludeTypes) {
            return in_array((int) $item, $activeIncludeTypes, true);
        }));

        // Remove existing mappings for this package
        $this->packageIncludeModel->where('package_id', $packageId)->delete();

        if (! empty($selected)) {
            $insertData = [];

            foreach ($selected as $index => $includeTypeId) {
                $insertData[] = [
                    'package_id'              => (int) $packageId,
                    'package_include_type_id' => (int) $includeTypeId,
                    'sort_order'              => $index + 1,
                    'status'                  => 1,
                ];
            }

            $result = $this->packageIncludeModel->insertBatch($insertData);

            if ($result === false) {
                return redirect()
                    ->to('/packages/edit/' . $packageId . '#inclusions')
                    ->withInput()
                    ->with('errors', $this->packageIncludeModel->errors());
            }
        }

        return redirect()
            ->to('/packages/edit/' . $packageId . '#inclusions')
            ->with('success', 'Package inclusions updated successfully!');
    }

    public function storeExclusions($packageId)
    {
        $this->findPackage($packageId);

        $selected = $this->request->getPost('package_exclude_type_ids');
        $selected = is_array($selected) ? array_values($selected) : [];
        $selected = array_filter($selected, fn($value) => $value !== null && $value !== '');
        $selected = array_map('intval', $selected);
        $selected = array_values(array_unique($selected));

        $activeExcludeTypes = array_map('intval', array_column($this->getPackageExcludeTypes(), 'id'));
        $selected = array_values(array_filter($selected, function ($item) use ($activeExcludeTypes) {
            return in_array((int) $item, $activeExcludeTypes, true);
        }));

        $this->packageExcludeModel->where('package_id', $packageId)->delete();

        if (! empty($selected)) {
            $insertData = [];

            foreach ($selected as $index => $excludeTypeId) {
                $insertData[] = [
                    'package_id'               => (int) $packageId,
                    'package_exclude_type_id'  => (int) $excludeTypeId,
                    'sort_order'               => $index + 1,
                    'status'                   => 1,
                ];
            }

            $result = $this->packageExcludeModel->insertBatch($insertData);

            if ($result === false) {
                return redirect()
                    ->to('/packages/edit/' . $packageId . '#exclusions')
                    ->withInput()
                    ->with('errors', $this->packageExcludeModel->errors());
            }
        }

        return redirect()
            ->to('/packages/edit/' . $packageId . '#exclusions')
            ->with('success', 'Package exclusions updated successfully!');
    }

    public function uploadImage($packageId)
    {
        $this->findPackage($packageId);

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


        $originalPath  = FCPATH . 'uploads/packages/' . $packageId . '/original/';
        $thumbPath    = FCPATH . 'uploads/packages/' . $packageId . '/thumb/';

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
            ->fit(400, 300, 'center')
            ->save($thumbPath . $newName);

        $relativePath = 'uploads/packages/' . $packageId . '/original/' . $newName;
        $lastOrder = $this->packageImageModel
            ->selectMax('sort_order')
            ->where('package_id', $packageId)
            ->first();

        $sortOrder = 1;

        if (! empty($lastOrder) && isset($lastOrder['sort_order'])) {
            $sortOrder = ((int) $lastOrder['sort_order']) + 1;
        }

        $data = [
            'package_id' => (int) $packageId,
            'image' => $relativePath,
            'alt_text'   => null,
            'sort_order' => $sortOrder,
            'status' => 1,
        ];

        $insertId = $this->packageImageModel->insert($data);

        if (! $insertId) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'errors' => $this->packageImageModel->errors(),
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
        $packageImage = $this->findPackageImage($imageId);
        $filePath = FCPATH . $packageImage['image'];

        if (is_file($filePath)) {
            @unlink($filePath);
        }

        if (! $this->packageImageModel->delete($imageId)) {
            return $this->response->setStatusCode(500)
                ->setJSON([
                    'success' => false,
                    'errors' => $this->packageImageModel->errors(),
                    'csrfHash' => csrf_hash(),
                ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'csrfHash' => csrf_hash(),
        ]);
    }

    private function getPackageIncludeTypes(): array
    {
        return $this->packageIncludeTypeModel
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    private function getPackageIncludeTypeIds($packageId): array
    {
        return array_column($this->packageIncludeModel
            ->where('package_id', $packageId)
            ->orderBy('sort_order', 'ASC')
            ->findAll(), 'package_include_type_id');
    }

    private function getPackageExcludeTypes(): array
    {
        return $this->packageExcludeTypeModel
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    private function getPackageExcludeTypeIds($packageId): array
    {
        return array_column($this->packageExcludeModel
            ->where('package_id', $packageId)
            ->orderBy('sort_order', 'ASC')
            ->findAll(), 'package_exclude_type_id');
    }

    private function getPackageItineraries($packageId): array
    {
        return $this->packageItineraryModel
            ->where('package_id', $packageId)
            ->orderBy('day_number', 'ASC')
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    private function getPackageImages($packageId): array
    {
        return $this->packageImageModel
            ->where('package_id', $packageId)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    private function findPackageImage($id): array
    {
        $image = $this->packageImageModel->find($id);

        if (! $image) {
            throw new PageNotFoundException('Package image not found');
        }

        return $image;
    }

    private function findPackageItinerary($id): array
    {
        $itinerary = $this->packageItineraryModel->find($id);

        if (! $itinerary) {
            throw new PageNotFoundException('Package itinerary not found');
        }

        return $itinerary;
    }

    private function getPackageFacts($packageId): array
    {
        return $this->packageFactModel
            ->where('package_id', $packageId)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    private function findPackageFact($id): array
    {
        $fact = $this->packageFactModel->find($id);

        if (! $fact) {
            throw new PageNotFoundException('Package fact not found');
        }

        return $fact;
    }

    public function update($id)
    {
        $package = $this->findPackage($id);

        $rules = [
            'destination_id'      => 'required|numeric',
            'package_category_ids' => 'required',
            'hotel_category_id'   => 'required|numeric',
            'meal_plan_type_id'   => 'required|numeric',
            'transport_type_id'   => 'required|numeric',
            'title'               => 'required|min_length[2]|max_length[255]',
            'slug'                => 'permit_empty|is_unique[t_packages.slug,id,' . $id . ']|min_length[2]|max_length[255]',
            'short_description'   => 'permit_empty|max_length[500]',
            'description'         => 'permit_empty',
            'duration_days'       => 'required|is_natural_no_zero',
            'duration_nights'     => 'required|is_natural',
            'starting_price'      => 'required|decimal',
            'sale_price'          => 'permit_empty|decimal',
            'featured_image'      => 'permit_empty|is_image[featured_image]|max_size[featured_image,2048]|mime_in[featured_image,image/jpg,image/jpeg,image/png,image/webp]',
            'banner_image'        => 'permit_empty|is_image[banner_image]|max_size[banner_image,2048]|mime_in[banner_image,image/jpg,image/jpeg,image/png,image/webp]',
            'is_featured'         => 'required|in_list[0,1]',
            'status'              => 'required|in_list[0,1]',
            'sort_order'          => 'permit_empty|numeric',
            'meta_title'          => 'permit_empty|max_length[255]',
            'meta_keywords'       => 'permit_empty|max_length[1000]',
            'meta_description'    => 'permit_empty|max_length[1000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $selectedCategoryIds = $this->getSelectedPackageCategoryIds();
        if (empty($selectedCategoryIds)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', [
                    'package_category_ids' => 'Please select at least one package category.',
                ]);
        }

        $data = $this->getFormData();
        $deleteCurrentFeaturedImage = (bool) $this->request->getPost('delete_current_featured_image');
        $deleteCurrentBannerImage = (bool) $this->request->getPost('delete_current_banner_image');

        $featuredPath = $this->processPackageMediaUpload($id, 'featured_image');
        if ($featuredPath !== null) {
            $this->removePackageMediaImage($package['featured_image']);
            $data['featured_image'] = $featuredPath;
        } elseif ($deleteCurrentFeaturedImage) {
            $this->removePackageMediaImage($package['featured_image']);
            $data['featured_image'] = null;
        }

        $bannerPath = $this->processPackageMediaUpload($id, 'banner_image');
        if ($bannerPath !== null) {
            $this->removePackageMediaImage($package['banner_image']);
            $data['banner_image'] = $bannerPath;
        } elseif ($deleteCurrentBannerImage) {
            $this->removePackageMediaImage($package['banner_image']);
            $data['banner_image'] = null;
        }

        if (! $this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->model->errors());
        }

        $this->syncPackageCategories((int) $id, $selectedCategoryIds);

        return redirect()
            ->to('/packages/edit/' . $id)
            ->with('success', 'Package updated successfully!');
    }

    public function delete($id)
    {
        $this->findPackage($id);

        if (! $this->model->delete($id)) {
            return redirect()->back()
                ->with('errors', $this->model->errors());
        }

        return redirect()
            ->to('/packages')
            ->with('success', 'Package deleted successfully!');
    }

    private function findPackage($id): array
    {
        $package = $this->model->find($id);

        if (! $package) {
            throw new PageNotFoundException('Package not found');
        }

        return $package;
    }

    private function getFormData(): array
    {
        $slug = trim((string) $this->request->getPost('slug'));

        if ($slug === '') {
            $slug = generate_slug($this->request->getPost('title'));
        } else {
            $slug = generate_slug($slug);
        }

        return [
            'destination_id'      => $this->request->getPost('destination_id'),
            'package_category_id' => $this->getPrimaryPackageCategoryId(),
            'hotel_category_id'   => $this->request->getPost('hotel_category_id'),
            'meal_plan_type_id'   => $this->request->getPost('meal_plan_type_id'),
            'transport_type_id'   => $this->request->getPost('transport_type_id'),
            'title'               => trim((string) $this->request->getPost('title')),
            'slug'                => $slug,
            'short_description'   => $this->request->getPost('short_description'),
            'description'         => $this->request->getPost('description'),
            'duration_days'       => $this->request->getPost('duration_days') ?? 0,
            'duration_nights'     => $this->request->getPost('duration_nights') ?? 0,
            'starting_price'      => $this->request->getPost('starting_price'),
            'sale_price'          => $this->request->getPost('sale_price'),
            'is_featured'         => $this->request->getPost('is_featured') ?? 0,
            'status'              => $this->request->getPost('status') ?? 1,
            'sort_order'          => $this->request->getPost('sort_order') ?? 0,
            'meta_title'          => $this->request->getPost('meta_title'),
            'meta_keywords'       => $this->request->getPost('meta_keywords'),
            'meta_description'    => $this->request->getPost('meta_description'),
        ];
    }

    private function processPackageMediaUpload(int $packageId, string $fieldName): ?string
    {
        $file = $this->request->getFile($fieldName);

        if (! $file || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (! $file->isValid()) {
            return null;
        }
        $allowedTypes = [
            'image/jpeg',
            'image/jpg',
            'image/png',
            'image/webp',
        ];

        if (! in_array($file->getMimeType(), $allowedTypes, true)) {
            session()->setFlashdata('errors', [
                $fieldName => ucfirst(str_replace('_', ' ', $fieldName)) . ' must be a JPG, PNG, or WEBP image.',
            ]);
            return false;
        }
        $uploadPath = FCPATH . 'uploads/packages/' . $packageId . '/original/';
        $thumbPath = FCPATH . 'uploads/packages/' . $packageId . '/thumb/';

        if (! is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if (! is_dir($thumbPath)) {
            mkdir($thumbPath, 0755, true);
        }

        $fileName = $file->getRandomName();
        $file->move($uploadPath, $fileName);

        $absoluteOriginal = $uploadPath . $fileName;
        $absoluteThumb = $thumbPath . $fileName;

        service('image')
            ->withFile($absoluteOriginal)
            ->fit(400, 300, 'center')
            ->save($absoluteThumb);

        return 'uploads/packages/' . $packageId . '/original/' . $fileName;
    }

    private function removePackageMediaImage(?string $relativePath): void
    {
        if (empty($relativePath)) {
            return;
        }

        $absolutePath = FCPATH . $relativePath;

        if (is_file($absolutePath)) {
            @unlink($absolutePath);
        }

        if (strpos($relativePath, '/original/') !== false) {
            $thumbRelative = str_replace('/original/', '/thumb/', $relativePath);
            $absoluteThumb = FCPATH . $thumbRelative;
            if (is_file($absoluteThumb)) {
                @unlink($absoluteThumb);
            }
        }
    }

    private function getFormOptions(): array
    {
        $destinations = $this->destinationModel->findAll();
        $packageCategories = $this->packageCategoryModel->findAll();
        $hotelCategories = $this->hotelCategoryModel->findAll();
        $mealPlanTypes = $this->mealPlanTypeModel->findAll();
        $transportTypes = $this->transportTypeModel->findAll();

        $packageFactTypes = $this->packageFactTypeModel
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return [
            'destinations'       => $destinations,
            'packageCategories'  => $packageCategories,
            'hotelCategories'    => $hotelCategories,
            'mealPlanTypes'      => $mealPlanTypes,
            'transportTypes'     => $transportTypes,
            'packageFactTypes'   => $packageFactTypes,
            'packageFactTypeMap' => array_column($packageFactTypes, null, 'id'),
        ];
    }

    private function getOptionMaps(): array
    {
        return [
            'destinationMap'    => array_column($this->destinationModel->findAll(), 'name', 'id'),
            'categoryMap'       => array_column($this->packageCategoryModel->findAll(), 'name', 'id'),
            'hotelCategoryMap'  => array_column($this->hotelCategoryModel->findAll(), 'name', 'id'),
            'mealPlanTypeMap'   => array_column($this->mealPlanTypeModel->findAll(), 'name', 'id'),
            'transportTypeMap'  => array_column($this->transportTypeModel->findAll(), 'name', 'id'),
        ];
    }

    private function getSelectedPackageCategoryIds(): array
    {
        $selected = $this->request->getPost('package_category_ids');
        $selected = is_array($selected) ? array_values($selected) : [];
        $selected = array_filter($selected, fn($value) => $value !== null && $value !== '');

        return array_values(array_unique(array_map('intval', $selected)));
    }

    private function getPrimaryPackageCategoryId(): int
    {
        $selected = $this->getSelectedPackageCategoryIds();

        return (int) ($selected[0] ?? 0);
    }

    private function syncPackageCategories(int $packageId, array $categoryIds): void
    {
        $this->packageCategoryRelationModel->where('package_id', $packageId)->delete();

        if (empty($categoryIds)) {
            return;
        }

        $insertData = [];
        foreach ($categoryIds as $categoryId) {
            $insertData[] = [
                'package_id' => $packageId,
                'category_id' => (int) $categoryId,
            ];
        }

        $this->packageCategoryRelationModel->insertBatch($insertData);
    }

    private function getSelectedPackageCategoryIdsForPackage($packageId, array $package): array
    {
        $selected = array_column(
            $this->packageCategoryRelationModel
                ->where('package_id', $packageId)
                ->findAll(),
            'category_id'
        );

        if (empty($selected) && ! empty($package['package_category_id'])) {
            $selected = [(int) $package['package_category_id']];
        }

        return array_values(array_map('intval', $selected));
    }

    private function getPackageCategoryNamesByPackage(array $packages): array
    {
        $rows = $this->packageCategoryRelationModel
            ->select('t_package_category_relations.package_id, mst_package_categories.name')
            ->join('mst_package_categories', 'mst_package_categories.id = t_package_category_relations.category_id')
            ->orderBy('mst_package_categories.name', 'ASC')
            ->findAll();

        $map = [];
        foreach ($rows as $row) {
            $map[(int) $row['package_id']][] = $row['name'];
        }

        $categoryMap = array_column($this->packageCategoryModel->findAll(), 'name', 'id');
        foreach ($packages as $package) {
            $packageId = (int) $package['id'];
            if (! empty($map[$packageId]) || empty($package['package_category_id'])) {
                continue;
            }

            $legacyCategoryId = (int) $package['package_category_id'];
            if (isset($categoryMap[$legacyCategoryId])) {
                $map[$packageId] = [$categoryMap[$legacyCategoryId]];
            }
        }

        return $map;
    }
}
