<?php

namespace App\Controllers\Api;

use App\Models\GalleryImageModel;

class Gallery extends BaseApiController
{
    private const GALLERY_TYPES = [
        'hotel'   => 'Hotel',
        'car'     => 'Car',
        'cruise'  => 'Cruise',
        'flight'  => 'Flight',
        'visa'    => 'Visa',
        'forex'   => 'Forex',
        'package' => 'Package',
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
            return $this->error('Invalid gallery type', [
                'gallery_type' => 'Please select a valid gallery type.',
            ], 422);
        }

        $query = $this->galleryImageModel
            ->where('status', 1)
            ->where('deleted_at', null)
            ->orderBy("FIELD(gallery_type, '" . implode("','", array_keys(self::GALLERY_TYPES)) . "')", '', false)
            ->orderBy('id', 'DESC');

        if ($galleryType !== 'all') {
            $query->where('gallery_type', $galleryType);
        }

        return $this->success([
            'selected_gallery_type' => $galleryType,
            'filters' => [
                'gallery_types' => $this->getGalleryTypeOptions(),
            ],
            'images' => array_map(fn($image) => $this->formatImage($image), $query->findAll()),
        ]);
    }

    private function getGalleryTypeOptions(): array
    {
        $options = [
            [
                'value' => 'all',
                'label' => 'All',
            ],
        ];

        foreach (self::GALLERY_TYPES as $value => $label) {
            $options[] = [
                'value' => $value,
                'label' => $label,
            ];
        }

        return $options;
    }

    private function formatImage(array $image): array
    {
        $galleryType = (string) ($image['gallery_type'] ?? '');

        return [
            'id' => (int) $image['id'],
            'gallery_type' => $galleryType,
            'gallery_type_label' => self::GALLERY_TYPES[$galleryType] ?? ucfirst($galleryType),
            'image' => $this->imageUrl($image['image'] ?? null),
            'thumb' => $this->imageUrl($this->thumbPath($image['image'] ?? null)),
        ];
    }

    private function thumbPath(?string $image): ?string
    {
        if (empty($image)) {
            return null;
        }

        return str_replace('/original/', '/thumb/', $image);
    }
}
