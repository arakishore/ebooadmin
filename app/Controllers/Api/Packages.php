<?php

namespace App\Controllers\Api;

use App\Models\DestinationModel;
use App\Models\PackageCategoryRelationModel;
use App\Models\PackageExcludeModel;
use App\Models\PackageFactModel;
use App\Models\PackageImageModel;
use App\Models\PackageIncludeModel;
use App\Models\PackageItineraryModel;
use App\Models\PackageModel;

class Packages extends BaseApiController
{
    protected PackageModel $packageModel;
    protected DestinationModel $destinationModel;
    protected PackageCategoryRelationModel $categoryRelationModel;
    protected PackageImageModel $packageImageModel;
    protected PackageItineraryModel $itineraryModel;
    protected PackageIncludeModel $includeModel;
    protected PackageExcludeModel $excludeModel;
    protected PackageFactModel $factModel;

    public function __construct()
    {
        $this->packageModel = new PackageModel();
        $this->destinationModel = new DestinationModel();
        $this->categoryRelationModel = new PackageCategoryRelationModel();
        $this->packageImageModel = new PackageImageModel();
        $this->itineraryModel = new PackageItineraryModel();
        $this->includeModel = new PackageIncludeModel();
        $this->excludeModel = new PackageExcludeModel();
        $this->factModel = new PackageFactModel();
    }

    public function index()
    {
        $destination = $this->request->getGet('destination');
        $category = $this->request->getGet('category');
        $keyword = $this->request->getGet('keyword');
        $featured = $this->request->getGet('featured');

        $query = $this->packageModel
            ->select('t_packages.*,
                mst_hotel_categories.name AS hotel_category_name,
                mst_meal_plan_types.name AS meal_plan_type_name')
             ->join('mst_hotel_categories', 'mst_hotel_categories.id = t_packages.hotel_category_id', 'left')
            ->join('mst_meal_plan_types', 'mst_meal_plan_types.id = t_packages.meal_plan_type_id', 'left')    
            ->where('t_packages.status', 1)
            ->orderBy('t_packages.sort_order', 'ASC')
            ->orderBy('t_packages.id', 'DESC');
        if ($featured == '1') {
            $query->where('t_packages.is_featured', 1);
        }

        if (! empty($destination)) {
            $query
                ->join('mst_destinations', 'mst_destinations.id = t_packages.destination_id')
                ->groupStart()
                ->where('mst_destinations.slug', $destination)
                ->orWhere('t_packages.destination_id', $destination)
                ->groupEnd();
        }

        if (! empty($category)) {
            $query
                ->join('t_package_category_relations', 't_package_category_relations.package_id = t_packages.id')
                ->join('mst_package_categories', 'mst_package_categories.id = t_package_category_relations.category_id')
                ->groupStart()
                ->where('mst_package_categories.slug', $category)
                ->orWhere('t_package_category_relations.category_id', $category)
                ->groupEnd()
                ->groupBy('t_packages.id');
        }

        if (! empty($keyword)) {
            $query
                ->groupStart()
                ->like('t_packages.title', $keyword)
                ->orLike('t_packages.short_description', $keyword)
                ->groupEnd();
        }

        $packages = $query->findAll();
        $packageIds = array_map('intval', array_column($packages, 'id'));

        return $this->success(array_map(
            fn($package) => $this->formatPackageListItem($package, $packageIds),
            $packages
        ));
    }

    public function show($slug)
    {
        $package = $this->packageModel
            ->select('
                t_packages.*,
                mst_hotel_categories.name AS hotel_category_name,
                mst_meal_plan_types.name AS meal_plan_type_name
            ')
            ->join('mst_hotel_categories', 'mst_hotel_categories.id = t_packages.hotel_category_id', 'left')
            ->join('mst_meal_plan_types', 'mst_meal_plan_types.id = t_packages.meal_plan_type_id', 'left')
            ->where('t_packages.slug', $slug)
            ->where('t_packages.status', 1)
            ->first();

        if (! $package) {
            return $this->error('Package not found', [], 404);
        }

        $data = $this->formatPackageListItem($package, [(int) $package['id']]);
        $data['description'] = $package['description'] ?? null;
        $data['banner_image'] = $this->imageUrl($package['banner_image'] ?? null);
        $data['starting_price'] = $package['starting_price'] ?? null;
        $data['sale_price'] = $package['sale_price'] ?? null;
        $data['gallery'] = $this->getGallery((int) $package['id']);
        $data['itineraries'] = $this->getItineraries((int) $package['id']);
        $data['inclusions'] = $this->getInclusions((int) $package['id']);
        $data['exclusions'] = $this->getExclusions((int) $package['id']);
        $data['facts'] = $this->getFacts((int) $package['id']);

        return $this->success($data);
    }

    private function formatPackageListItem(array $package, array $packageIds): array
    {
        $destination = $this->destinationModel->find($package['destination_id']);
        $categories = $this->getCategories($packageIds)[(int) $package['id']] ?? [];

        return [
            'id' => (int) $package['id'],
            'title' => $package['title'],
            'slug' => $package['slug'],
            'featured_image' => $this->imageUrl($package['featured_image'] ?? null),
            'duration' => $this->formatDuration($package),
            'hotel_category' => [
                'id' => (int) ($package['hotel_category_id'] ?? 0),
                'name' => $package['hotel_category_name'] ?? '',
            ],

            'meal_plan_type' => [
                'id' => (int) ($package['meal_plan_type_id'] ?? 0),
                'name' => $package['meal_plan_type_name'] ?? '',
            ],
            'short_description' => $package['short_description'] ?? null,
            'starting_price' => $package['starting_price'] ?? null,
            'sale_price' => $package['sale_price'] ?? null,
            'featured' => (bool) ($package['is_featured'] ?? false),
            'meta_title' => $package['meta_title'] ?? null,
            'meta_keywords' => $package['meta_keywords'] ?? null,
            'meta_description' => $package['meta_description'] ?? null,
            'destination' => $destination ? [
                'id' => (int) $destination['id'],
                'name' => $destination['name'],
                'slug' => $destination['slug'],
                'country' => $destination['country'] ?? null,
                'city' => $destination['city'] ?? null,
            ] : null,

            'categories' => $categories,
        ];
    }

    private function getCategories(array $packageIds): array
    {
        if (empty($packageIds)) {
            return [];
        }

        $rows = $this->categoryRelationModel
            ->select('t_package_category_relations.package_id, mst_package_categories.id, mst_package_categories.name, mst_package_categories.slug')
            ->join('mst_package_categories', 'mst_package_categories.id = t_package_category_relations.category_id')
            ->whereIn('t_package_category_relations.package_id', $packageIds)
            ->where('mst_package_categories.status', 1)
            ->orderBy('mst_package_categories.name', 'ASC')
            ->findAll();

        $map = [];
        foreach ($rows as $row) {
            $map[(int) $row['package_id']][] = [
                'id' => (int) $row['id'],
                'name' => $row['name'],
                'slug' => $row['slug'],
            ];
        }

        return $map;
    }

    private function getGallery(int $packageId): array
    {
        $images = $this->packageImageModel
            ->where('package_id', $packageId)
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return array_map(fn($image) => [
            'id' => (int) $image['id'],
            'image' => $this->imageUrl($image['image'] ?? null),
            'alt_text' => $image['alt_text'] ?? null,
            'sort_order' => (int) ($image['sort_order'] ?? 0),
        ], $images);
    }

    private function getItineraries(int $packageId): array
    {
        return $this->itineraryModel
            ->where('package_id', $packageId)
            ->where('status', 1)
            ->orderBy('day_number', 'ASC')
            ->orderBy('sort_order', 'ASC')
            ->findAll();
    }

    private function getInclusions(int $packageId): array
    {
        return $this->includeModel
            ->select('t_package_includes.id, mst_package_include_types.name, mst_package_include_types.slug, mst_package_include_types.icon')
            ->join('mst_package_include_types', 'mst_package_include_types.id = t_package_includes.package_include_type_id')
            ->where('t_package_includes.package_id', $packageId)
            ->where('t_package_includes.status', 1)
            ->orderBy('t_package_includes.sort_order', 'ASC')
            ->findAll();
    }

    private function getExclusions(int $packageId): array
    {
        return $this->excludeModel
            ->select('t_package_excludes.id, mst_package_exclude_types.name, mst_package_exclude_types.slug, mst_package_exclude_types.icon')
            ->join('mst_package_exclude_types', 'mst_package_exclude_types.id = t_package_excludes.package_exclude_type_id')
            ->where('t_package_excludes.package_id', $packageId)
            ->where('t_package_excludes.status', 1)
            ->orderBy('t_package_excludes.sort_order', 'ASC')
            ->findAll();
    }

    private function getFacts(int $packageId): array
    {
        return $this->factModel
            ->select('t_package_facts.id, t_package_facts.value, mst_package_fact_types.name, mst_package_fact_types.slug, mst_package_fact_types.icon')
            ->join('mst_package_fact_types', 'mst_package_fact_types.id = t_package_facts.package_fact_type_id')
            ->where('t_package_facts.package_id', $packageId)
            ->where('t_package_facts.status', 1)
            ->orderBy('t_package_facts.sort_order', 'ASC')
            ->findAll();
    }

    private function formatDuration(array $package): string
    {
        return ((int) ($package['duration_days'] ?? 0)) . ' Days / ' . ((int) ($package['duration_nights'] ?? 0)) . ' Nights';
    }
}
