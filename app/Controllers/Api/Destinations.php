<?php

namespace App\Controllers\Api;

use App\Libraries\PackageFormatter;

use App\Models\DestinationImageModel;
use App\Models\DestinationModel;
use App\Models\PackageModel;

class Destinations extends BaseApiController
{
    protected DestinationModel $destinationModel;
    protected DestinationImageModel $destinationImageModel;
    protected PackageModel $packageModel;

    public function __construct()
    {
        $this->destinationModel = new DestinationModel();
        $this->destinationImageModel = new DestinationImageModel();
        $this->packageModel = new PackageModel();
    }

    public function index()
    {
        $destinations = $this->destinationModel
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();

        return $this->success(array_map(fn($destination) => $this->formatDestination($destination), $destinations));
    }

    public function show($slug)
    {
        $destination = $this->destinationModel
            ->where('slug', $slug)
            ->where('status', 1)
            ->first();

        if (! $destination) {
            return $this->error('Destination not found', [], 404);
        }

        $data = $this->formatDestination($destination);
        $data['description'] = $destination['description'] ?? null;
        $data['gallery'] = $this->getGallery((int) $destination['id']);
        //$data['packages'] = $this->getRelatedPackages((int) $destination['id']);
        $data['packages'] = $this->getRelatedPackages((int) $destination['id'], $destination);

        return $this->success($data);
    }

    private function formatDestination(array $destination): array
    {
        return [
            'id' => (int) $destination['id'],
            'name' => $destination['name'],
            'slug' => $destination['slug'],
            'country' => $destination['country'] ?? null,
            'city' => $destination['city'] ?? null,
            'image' => $this->imageUrl($destination['image'] ?? null),
            'banner_image' => $this->imageUrl($destination['banner_image'] ?? null),
            'short_description' => $destination['description'] ?? null,
            'featured' => isset($destination['featured']) ? (bool) $destination['featured'] : false,
        ];
    }

    private function getGallery(int $destinationId): array
    {
        $images = $this->destinationImageModel
            ->where('destination_id', $destinationId)
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return array_map(fn($image) => [
            'id' => (int) $image['id'],
            'title' => $image['title'] ?? null,
            'image' => $this->imageUrl($image['image'] ?? null),
            'sort_order' => (int) ($image['sort_order'] ?? 0),
        ], $images);
    }

    private function getRelatedPackages(int $destinationId, array $destination): array
    {
        $packageFormatter = new PackageFormatter();

        $packages = $this->packageModel
            ->where('destination_id', $destinationId)
            ->where('status', 1)
            ->orderBy('sort_order', 'ASC')
            ->findAll();
        $packageIds = array_column($packages, 'id');
        $categoriesMap = $packageFormatter->getCategories($packageIds);

        return array_map(fn($package) => [
            'id' => (int) $package['id'],
            'title' => $package['title'],
            'slug' => $package['slug'],
            'featured_image' => $this->imageUrl($package['featured_image'] ?? null),
            'duration' => $this->formatDuration($package),

            'short_description' => $package['short_description'] ?? null,
            'starting_price' => $package['starting_price'] ?? null,
            'sale_price' => $package['sale_price'] ?? null,
            'featured' => (bool) ($package['is_featured'] ?? false),
            'categories' => $categoriesMap[(int) $package['id']] ?? [],

            'destination' => [
                'id' => (int) $destination['id'],
                'name' => $destination['name'],
                'slug' => $destination['slug'],
                'country' => $destination['country'] ?? null,
                'city' => $destination['city'] ?? null,
            ],

        ], $packages);
    }

    private function formatDuration(array $package): string
    {
        return ((int) ($package['duration_days'] ?? 0)) . ' Days / ' . ((int) ($package['duration_nights'] ?? 0)) . ' Nights';
    }
}
