<?php
namespace App\Libraries;

use App\Models\PackageCategoryRelationModel;

class PackageFormatter
{
    protected PackageCategoryRelationModel $categoryRelationModel;

    public function __construct()
    {
        $this->categoryRelationModel = new PackageCategoryRelationModel();
    }

    public function getCategories(array $packageIds): array
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
}