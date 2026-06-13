<?php

/**
 * @var array<string,mixed> $package
 * @var array<int,array<string,mixed>> $destinations
 * @var array<int,array<string,mixed>> $packageCategories
 * @var array<int,array<string,mixed>> $hotelCategories
 * @var array<int,array<string,mixed>> $mealPlanTypes
 * @var array<int,array<string,mixed>> $transportTypes
 * @var array<int,array<string,mixed>> $packageFactTypes
 * @var array<int,array<string,mixed>> $packageFactTypeMap
 * @var array<int,array<string,mixed>> $packageFacts
 * @var array<int,array<string,mixed>> $packageIncludeTypes
 * @var array<int,int> $selectedPackageIncludeTypeIds
 * @var array<int,array<string,mixed>> $packageExcludeTypes
 * @var array<int,int> $selectedPackageExcludeTypeIds
 * @var array<int,array<string,mixed>> $packageImages
 */ ?>

<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('packages') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">Package</a>
                <span class="breadcrumb-item active">Edit Package</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        <div class="collapse d-lg-block ms-lg-auto" id="breadcrumb_elements">
            <div class="d-lg-flex mb-2 mb-lg-0">
                <a href="<?= base_url('packages') ?>" class="d-flex align-items-center text-body py-2">
                    <i class="icon-arrow-left7 me-2"></i>
                    Back to Packages List
                </a>


            </div>
        </div>
    </div>
</div>
<div class="content">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title"> Edit Package </h6>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <ul class="nav nav-tabs nav-tabs-underline mb-3">
                <li class="nav-item"><a href="#basic-info" class="nav-link active" data-bs-toggle="tab">Basic Info</a></li>
                <li class="nav-item"><a href="#facts" class="nav-link" data-bs-toggle="tab">Facts</a></li>
                <li class="nav-item"><a href="#itinerary" class="nav-link" data-bs-toggle="tab">Itinerary</a></li>
                <li class="nav-item"><a href="#inclusions" class="nav-link" data-bs-toggle="tab">Inclusions</a></li>
                <li class="nav-item"><a href="#exclusions" class="nav-link" data-bs-toggle="tab">Exclusions</a></li>
                <li class="nav-item"><a href="#gallery" class="nav-link" data-bs-toggle="tab">Gallery</a></li>
                <!-- <li class="nav-item"><a href="#hotels" class="nav-link" data-bs-toggle="tab">Hotels</a></li> -->
                <!-- <li class="nav-item"><a href="#pricing" class="nav-link" data-bs-toggle="tab">Pricing</a></li> -->
                <!-- <li class="nav-item"><a href="#seo" class="nav-link" data-bs-toggle="tab">SEO</a></li> -->
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="basic-info">


                    <form action="<?= base_url('packages/update/' . esc((string) $package['id'])) ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= esc((string) $package['id']) ?>">
                        <fieldset>

                            <legend class="fs-base fw-bold border-bottom pb-2 mb-3">General</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="destination_id" class="form-label">Destination <span class="text-danger">*</span></label>
                                        <select class="form-control select <?= session('errors.destination_id') ? 'is-invalid' : '' ?>" id="destination_id" name="destination_id" required>
                                            <option value="">Select destination</option>
                                            <?php foreach ($destinations as $destination): ?>
                                                <option value="<?= esc($destination['id']) ?>" <?= old('destination_id', $package['destination_id']) == $destination['id'] ? 'selected' : '' ?>><?= esc($destination['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if (session('errors.destination_id')): ?>
                                            <div class="invalid-feedback"><?= session('errors.destination_id') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="package_category_ids" class="form-label">Package Categories <span class="text-danger">*</span></label>
                                        <?php $selectedCategories = array_map('intval', (array) old('package_category_ids', $selectedPackageCategoryIds ?? [])); ?>
                                        <select class="form-control form-control-select2 <?= session('errors.package_category_ids') ? 'is-invalid' : '' ?>" id="package_category_ids" name="package_category_ids[]" multiple="multiple" data-placeholder="Select categories" required>
                                            <?php foreach ($packageCategories as $category): ?>
                                                <option value="<?= esc($category['id']) ?>" <?= in_array((int) $category['id'], $selectedCategories, true) ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if (session('errors.package_category_ids')): ?>
                                            <div class="invalid-feedback"><?= session('errors.package_category_ids') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="hotel_category_id" class="form-label">Hotel Category <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-select2 <?= session('errors.hotel_category_id') ? 'is-invalid' : '' ?>" id="hotel_category_id" name="hotel_category_id" data-minimum-results-for-search="Infinity" required>
                                            <option value="">Select hotel category</option>
                                            <?php foreach ($hotelCategories as $hotelCategory): ?>
                                                <option value="<?= esc($hotelCategory['id']) ?>" <?= old('hotel_category_id', $package['hotel_category_id']) == $hotelCategory['id'] ? 'selected' : '' ?>><?= esc($hotelCategory['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if (session('errors.hotel_category_id')): ?>
                                            <div class="invalid-feedback"><?= session('errors.hotel_category_id') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="meal_plan_type_id" class="form-label">Meal Plan Type <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-select2 <?= session('errors.meal_plan_type_id') ? 'is-invalid' : '' ?>" id="meal_plan_type_id" name="meal_plan_type_id" data-minimum-results-for-search="Infinity" required>
                                            <option value="">Select meal plan</option>
                                            <?php foreach ($mealPlanTypes as $mealPlanType): ?>
                                                <option value="<?= esc($mealPlanType['id']) ?>" <?= old('meal_plan_type_id', $package['meal_plan_type_id']) == $mealPlanType['id'] ? 'selected' : '' ?>><?= esc($mealPlanType['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if (session('errors.meal_plan_type_id')): ?>
                                            <div class="invalid-feedback"><?= session('errors.meal_plan_type_id') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="transport_type_id" class="form-label">Transport Type <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-select2 <?= session('errors.transport_type_id') ? 'is-invalid' : '' ?>" id="transport_type_id" name="transport_type_id" data-minimum-results-for-search="Infinity" required>
                                            <option value="">Select transport type</option>
                                            <?php foreach ($transportTypes as $transportType): ?>
                                                <option value="<?= esc($transportType['id']) ?>" <?= old('transport_type_id', $package['transport_type_id']) == $transportType['id'] ? 'selected' : '' ?>><?= esc($transportType['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <?php if (session('errors.transport_type_id')): ?>
                                            <div class="invalid-feedback"><?= session('errors.transport_type_id') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?= session('errors.title') ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= esc(old('title', $package['title'])) ?>" placeholder="Enter package title" required>
                                <?php if (session('errors.title')): ?>
                                    <div class="invalid-feedback"><?= session('errors.title') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" class="form-control <?= session('errors.slug') ? 'is-invalid' : '' ?>" id="slug" name="slug" value="<?= esc(old('slug', $package['slug'])) ?>" placeholder="Leave empty to auto-generate from title">
                                <small class="text-muted">Leave empty to auto-generate from the title</small>
                                <?php if (session('errors.slug')): ?>
                                    <div class="invalid-feedback"><?= session('errors.slug') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label for="short_description" class="form-label">Short Description</label>
                                <textarea class="form-control <?= session('errors.short_description') ? 'is-invalid' : '' ?>" id="short_description" name="short_description" rows="3" placeholder="Enter short description"><?= esc(old('short_description', $package['short_description'])) ?></textarea>
                                <?php if (session('errors.short_description')): ?>
                                    <div class="invalid-feedback"><?= session('errors.short_description') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control <?= session('errors.description') ? 'is-invalid' : '' ?>" id="description" name="description" rows="5" placeholder="Enter package description"><?= esc(old('description', $package['description'])) ?></textarea>
                                <?php if (session('errors.description')): ?>
                                    <div class="invalid-feedback"><?= session('errors.description') ?></div>
                                <?php endif; ?>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="fs-base fw-bold border-bottom pb-2 mb-3">Media</legend>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card border-dashed p-3 mb-3">
                                        <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                                            <div class="ratio ratio-16x9 rounded overflow-hidden bg-light" style="min-width:160px; max-width:240px;">
                                                <img id="featured_image_preview" src="<?= ! empty($package['featured_image']) ? base_url($package['featured_image']) : '' ?>" alt="Featured image" class="img-fluid rounded <?= empty($package['featured_image']) ? 'd-none' : '' ?>">
                                                <div id="featured_image_placeholder" class="d-flex align-items-center justify-content-center h-100 text-muted <?= ! empty($package['featured_image']) ? 'd-none' : '' ?>">
                                                    Featured image
                                                </div>
                                            </div>
                                            <div class="flex-fill">
                                                <label class="form-label d-block">Featured Image</label>
                                                <div class="mb-2">
                                                    <label for="featured_image" class="btn btn-outline-primary btn-sm">
                                                        <i class="ph-upload me-1"></i> Choose featured image
                                                    </label>
                                                    <input type="file" id="featured_image" name="featured_image" accept=".jpg,.jpeg,.png,.webp" class="d-none">
                                                </div>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" id="delete_current_featured_image" name="delete_current_featured_image" value="1" <?= old('delete_current_featured_image') === '1' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="delete_current_featured_image">Delete current image</label>
                                                </div>
                                                <p class="text-muted mb-1">Recommended size: original upload. JPG, JPEG, PNG or WEBP. Max 2MB.</p>
                                                <?php if (session('errors.featured_image')): ?>
                                                    <div class="text-danger small"><?= session('errors.featured_image') ?></div>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-dashed p-3 mb-3">
                                        <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                                            <div class="ratio ratio-16x9 rounded overflow-hidden bg-light" style="min-width:160px; max-width:240px;">
                                                <img id="banner_image_preview" src="<?= ! empty($package['banner_image']) ? base_url($package['banner_image']) : '' ?>" alt="Banner image" class="img-fluid rounded <?= empty($package['banner_image']) ? 'd-none' : '' ?>">
                                                <div id="banner_image_placeholder" class="d-flex align-items-center justify-content-center h-100 text-muted <?= ! empty($package['banner_image']) ? 'd-none' : '' ?>">
                                                    Map image
                                                </div>
                                            </div>
                                            <div class="flex-fill">
                                                <label class="form-label d-block">Map Image</label>
                                                <div class="mb-2">
                                                    <label for="banner_image" class="btn btn-outline-primary btn-sm">
                                                        <i class="ph-upload me-1"></i> Choose map image
                                                    </label>
                                                    <input type="file" id="banner_image" name="banner_image" accept=".jpg,.jpeg,.png,.webp" class="d-none">
                                                </div>
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input" type="checkbox" id="delete_current_banner_image" name="delete_current_banner_image" value="1" <?= old('delete_current_banner_image') === '1' ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="delete_current_banner_image">Delete current image</label>
                                                </div>
                                                <p class="text-muted mb-1">Recommended size: original upload. JPG, JPEG, PNG or WEBP. Max 2MB.</p>
                                                <?php if (session('errors.banner_image')): ?>
                                                    <div class="text-danger small"><?= session('errors.banner_image') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="duration_days" class="form-label">Duration Days <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control <?= session('errors.duration_days') ? 'is-invalid' : '' ?>" id="duration_days" name="duration_days" value="<?= esc(old('duration_days', $package['duration_days'])) ?>" min="1" required>
                                        <?php if (session('errors.duration_days')): ?>
                                            <div class="invalid-feedback"><?= session('errors.duration_days') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="duration_nights" class="form-label">Duration Nights <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control <?= session('errors.duration_nights') ? 'is-invalid' : '' ?>" id="duration_nights" name="duration_nights" value="<?= esc(old('duration_nights', $package['duration_nights'])) ?>" min="0" required>
                                        <?php if (session('errors.duration_nights')): ?>
                                            <div class="invalid-feedback"><?= session('errors.duration_nights') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="starting_price" class="form-label">Starting Price <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control <?= session('errors.starting_price') ? 'is-invalid' : '' ?>" id="starting_price" name="starting_price" value="<?= esc(old('starting_price', $package['starting_price'])) ?>" required>
                                        <?php if (session('errors.starting_price')): ?>
                                            <div class="invalid-feedback"><?= session('errors.starting_price') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="sale_price" class="form-label">Sale Price</label>
                                        <input type="number" step="0.01" class="form-control <?= session('errors.sale_price') ? 'is-invalid' : '' ?>" id="sale_price" name="sale_price" value="<?= esc(old('sale_price', $package['sale_price'])) ?>">
                                        <?php if (session('errors.sale_price')): ?>
                                            <div class="invalid-feedback"><?= session('errors.sale_price') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="is_featured" class="form-label">Featured</label>
                                        <select class="form-control form-control-select2 <?= session('errors.is_featured') ? 'is-invalid' : '' ?>" id="is_featured" name="is_featured" data-minimum-results-for-search="Infinity" required>
                                            <option value="1" <?= old('is_featured', $package['is_featured']) == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= old('is_featured', $package['is_featured']) == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                        <?php if (session('errors.is_featured')): ?>
                                            <div class="invalid-feedback"><?= session('errors.is_featured') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-select2 <?= session('errors.status') ? 'is-invalid' : '' ?>" id="status" name="status" data-minimum-results-for-search="Infinity" required>
                                            <option value="1" <?= old('status', $package['status']) == 1 ? 'selected' : '' ?>>Active</option>
                                            <option value="0" <?= old('status', $package['status']) == 0 ? 'selected' : '' ?>>Inactive</option>
                                        </select>
                                        <?php if (session('errors.status')): ?>
                                            <div class="invalid-feedback"><?= session('errors.status') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="sort_order" class="form-label">Sort Order</label>
                                        <input type="number" class="form-control <?= session('errors.sort_order') ? 'is-invalid' : '' ?>" id="sort_order" name="sort_order" value="<?= esc(old('sort_order', $package['sort_order'] ?? 0)) ?>">
                                        <?php if (session('errors.sort_order')): ?>
                                            <div class="invalid-feedback"><?= session('errors.sort_order') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>

                            <legend class="fs-base fw-bold border-bottom pb-2 mb-3">SEO</legend>
                            <div class="form-group mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text"
                                    class="form-control <?= session('errors.meta_title') ? 'is-invalid' : '' ?>"
                                    id="meta_title"
                                    name="meta_title"
                                    value="<?= esc(old('meta_title', $package['meta_title'] ?? '')) ?>">
                                <?php if (session('errors.meta_title')): ?>
                                    <div class="invalid-feedback"><?= session('errors.meta_title') ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group mb-3">
                                <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                <input type="text"
                                    class="form-control <?= session('errors.meta_keywords') ? 'is-invalid' : '' ?>"
                                    id="meta_keywords"
                                    name="meta_keywords"
                                    value="<?= esc(old('meta_keywords', $package['meta_keywords'] ?? '')) ?>">
                                <?php if (session('errors.meta_keywords')): ?>
                                    <div class="invalid-feedback"><?= session('errors.meta_keywords') ?></div>
                                <?php endif; ?>
                                <div class="form-text">comma-separated</div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control <?= session('errors.meta_description') ? 'is-invalid' : '' ?>" id="meta_description" name="meta_description" rows="3"><?= esc(old('meta_description', $package['meta_description'] ?? '')) ?></textarea>
                                <?php if (session('errors.meta_description')): ?>
                                    <div class="invalid-feedback"><?= session('errors.meta_description') ?></div>
                                <?php endif; ?>
                            </div>
                        </fieldset>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="icon-check"></i> Update Package
                            </button>
                            <a href="<?= base_url('packages') ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="facts">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h6 class="card-title">Existing Facts</h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Value</th>
                                                    <th>Sort</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($packageFacts)): ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">No facts found for this package.</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach ($packageFacts as $fact): ?>
                                                        <tr>
                                                            <td><?= esc((string) ($packageFactTypeMap[$fact['package_fact_type_id']]['name'] ?? '-')) ?></td>
                                                            <td><?= esc((string) $fact['value']) ?></td>
                                                            <td><?= esc((string) $fact['sort_order']) ?></td>
                                                            <td>
                                                                <?php if ($fact['status'] == 1): ?>
                                                                    <span class="badge bg-success">Active</span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-danger">Inactive</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <a href="#" class="list-icons-item text-primary fact-edit-button" data-fact-id="<?= esc($fact['id']) ?>" data-fact-type-id="<?= esc($fact['package_fact_type_id']) ?>" data-value="<?= esc($fact['value']) ?>" data-sortorder2="<?= esc($fact['sort_order']) ?>" data-status2="<?= esc($fact['status']) ?>" title="Edit">
                                                                    <i class="icon-pencil"></i>
                                                                </a>
                                                                <a href="<?= base_url('packages/facts/delete/' . $fact['id']) ?>" class="list-icons-item text-danger bootbox_custom" onclick1="return confirm('Are you sure?')" data-original-title="Delete">
                                                                    <i class="icon-trash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title" id="fact-form-title">Add Package Fact</h6>
                                </div>
                                <div class="card-body">
                                    <form action="<?= base_url('packages/facts/store/' . esc((string) $package['id'])) ?>" method="POST" id="package-fact-form">
                                        <?= csrf_field() ?>
                                        <input type="hidden" id="fact_id" name="fact_id" value="<?= esc(old('fact_id')) ?>">

                                        <div class="form-group mb-3">
                                            <label for="package_fact_type_id" class="form-label">Fact Type <span class="text-danger">*</span></label>
                                            <select class="form-control <?= session('errors.package_fact_type_id') ? 'is-invalid' : '' ?>" id="package_fact_type_id" name="package_fact_type_id" required>
                                                <option value="">Select fact type</option>
                                                <?php foreach ($packageFactTypes as $factType): ?>
                                                    <option value="<?= esc($factType['id']) ?>" <?= old('package_fact_type_id') == $factType['id'] ? 'selected' : '' ?>><?= esc($factType['name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php if (session('errors.package_fact_type_id')): ?>
                                                <div class="invalid-feedback"><?= session('errors.package_fact_type_id') ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="value" class="form-label">Value <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control <?= session('errors.value') ? 'is-invalid' : '' ?>" id="value" name="value" value="<?= esc(old('value')) ?>" required>
                                            <?php if (session('errors.value')): ?>
                                                <div class="invalid-feedback"><?= session('errors.value') ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="3" class="form-label">Sort Order2</label>
                                                    <input type="number" class="form-control <?= session('errors.sort_order') ? 'is-invalid' : '' ?>" id="sort_order2" name="sort_order" value="<?= esc(old('sort_order', 0)) ?>">
                                                    <?php if (session('errors.sort_order')): ?>
                                                        <div class="invalid-feedback"><?= session('errors.sort_order') ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select class="form-control <?= session('errors.status') ? 'is-invalid' : '' ?>" id="status2" name="status" required>
                                                        <option value="1" <?= old('status', '1') == '1' ? 'selected' : '' ?>>Active</option>
                                                        <option value="0" <?= old('status') === '0' ? 'selected' : '' ?>>Inactive</option>
                                                    </select>
                                                    <?php if (session('errors.status')): ?>
                                                        <div class="invalid-feedback"><?= session('errors.status') ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group text-end">
                                            <button type="submit" class="btn btn-primary" id="fact-submit-button">Add Fact</button>
                                            <button type="button" class="btn btn-light d-none" id="fact-cancel-button">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="itinerary">
                    <?php $itineraryMap = [];
                    foreach ($packageItineraries ?? [] as $item) {
                        $itineraryMap[$item['day_number']] = $item;
                    } ?>
                    <?php for ($day = 1; $day <= (int) $package['duration_days']; $day++): ?>
                        <?php $itinerary = $itineraryMap[$day] ?? null; ?>
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="card-title">Day <?= esc((string) $day) ?> Itinerary</h6>
                            </div>
                            <div class="card-body">
                                <form action="<?= base_url('packages/itinerary/store/' . esc((string) $package['id'])) ?>" method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="day_number" value="<?= esc((string) $day) ?>">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Day Number</label>
                                                <input type="text" class="form-control" value="<?= esc((string) $day) ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="title_itinerary_<?= $day ?>" class="form-label">Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control <?= session('errors.title') ? 'is-invalid' : '' ?>" id="title_itinerary_<?= $day ?>" name="title" value="<?= esc(old('title', $itinerary['title'] ?? '')) ?>" required>
                                                <?php if (session('errors.title')): ?>
                                                    <div class="invalid-feedback"><?= session('errors.title') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="description_itinerary_<?= $day ?>" class="form-label">Description</label>
                                        <textarea class="form-control <?= session('errors.description') ? 'is-invalid' : '' ?>" id="description_itinerary_<?= $day ?>" name="description" rows="3"><?= esc(old('description', $itinerary['description'] ?? '')) ?></textarea>
                                        <?php if (session('errors.description')): ?>
                                            <div class="invalid-feedback"><?= session('errors.description') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="meals_<?= $day ?>" class="form-label">Meals</label>
                                                <input type="text" class="form-control <?= session('errors.meals') ? 'is-invalid' : '' ?>" id="meals_<?= $day ?>" name="meals" value="<?= esc(old('meals', $itinerary['meals'] ?? '')) ?>">
                                                <?php if (session('errors.meals')): ?>
                                                    <div class="invalid-feedback"><?= session('errors.meals') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="overnight_stay_<?= $day ?>" class="form-label">Overnight Stay</label>
                                                <input type="text" class="form-control <?= session('errors.overnight_stay') ? 'is-invalid' : '' ?>" id="overnight_stay_<?= $day ?>" name="overnight_stay" value="<?= esc(old('overnight_stay', $itinerary['overnight_stay'] ?? '')) ?>">
                                                <?php if (session('errors.overnight_stay')): ?>
                                                    <div class="invalid-feedback"><?= session('errors.overnight_stay') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="sort_order_itinerary_<?= $day ?>" class="form-label">Sort Order</label>
                                                <input type="number" class="form-control <?= session('errors.sort_order') ? 'is-invalid' : '' ?>" id="sort_order_itinerary_<?= $day ?>" name="sort_order" value="<?= esc(old('sort_order', $itinerary['sort_order'] ?? 0)) ?>">
                                                <?php if (session('errors.sort_order')): ?>
                                                    <div class="invalid-feedback"><?= session('errors.sort_order') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="status_itinerary_<?= $day ?>" class="form-label">Status</label>
                                                <select class="form-control <?= session('errors.status') ? 'is-invalid' : '' ?>" id="status_itinerary_<?= $day ?>" name="status" required>
                                                    <option value="1" <?= old('status', (string) ($itinerary['status'] ?? '1')) == '1' ? 'selected' : '' ?>>Active</option>
                                                    <option value="0" <?= old('status', (string) ($itinerary['status'] ?? '1')) === '0' ? 'selected' : '' ?>>Inactive</option>
                                                </select>
                                                <?php if (session('errors.status')): ?>
                                                    <div class="invalid-feedback"><?= session('errors.status') ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group text-end">
                                        <button type="submit" class="btn btn-primary">Save Day <?= esc((string) $day) ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <div class="tab-pane fade" id="inclusions">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Package Inclusions</h6>
                                </div>
                                <div class="card-body">
                                    <form action="<?= base_url('packages/inclusions/store/' . esc((string) $package['id'])) ?>" method="POST">
                                        <?= csrf_field() ?>

                                        <div class="form-group mb-3">
                                            <label for="package_include_type_ids" class="form-label">Included Items</label>
                                            <?php $selectedIncludes = old('package_include_type_ids') ?? $selectedPackageIncludeTypeIds; ?>
                                            <select class="form-control form-control-select2" id="package_include_type_ids" name="package_include_type_ids[]" multiple="multiple" data-placeholder="Select package inclusions">
                                                <?php foreach ($packageIncludeTypes as $includeType): ?>
                                                    <option value="<?= esc($includeType['id']) ?>" <?= in_array((int) $includeType['id'], array_map('intval', (array) $selectedIncludes), true) ? 'selected' : '' ?>><?= esc($includeType['name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group text-end">
                                            <button type="submit" class="btn btn-primary">Save Inclusions</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="exclusions">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title">Package Exclusions</h6>
                                </div>
                                <div class="card-body">
                                    <form action="<?= base_url('packages/exclusions/store/' . esc((string) $package['id'])) ?>" method="POST">
                                        <?= csrf_field() ?>

                                        <div class="form-group mb-3">
                                            <label for="package_exclude_type_ids" class="form-label">Excluded Items</label>
                                            <?php $selectedExcludes = old('package_exclude_type_ids') ?? $selectedPackageExcludeTypeIds; ?>
                                            <select class="form-control form-control-select2" id="package_exclude_type_ids" name="package_exclude_type_ids[]" multiple="multiple" data-placeholder="Select package exclusions">
                                                <?php foreach ($packageExcludeTypes as $excludeType): ?>
                                                    <option value="<?= esc($excludeType['id']) ?>" <?= in_array((int) $excludeType['id'], array_map('intval', (array) $selectedExcludes), true) ? 'selected' : '' ?>><?= esc($excludeType['name']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="form-group text-end">
                                            <button type="submit" class="btn btn-primary">Save Exclusions</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="gallery">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                    <div>
                                        <h6 class="card-title">Package Gallery</h6>
                                        <span class="text-muted d-block">Upload multiple gallery images and manage them without page reload.</span>
                                    </div>
                                    <div>
                                        <label for="package-gallery-upload" class="btn btn-primary btn-sm">
                                            <i class="ph-upload me-1"></i> Select Images
                                        </label>
                                        <input type="file" id="package-gallery-upload" class="d-none" accept=".jpg,.jpeg,.png,.webp" multiple>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="package-gallery-feedback"></div>
                                    <div class="row" id="package-gallery-list">
                                        <?php foreach ($packageImages as $image): ?>
                                            <div class="col-6 col-sm-4 col-md-3 mb-3" data-image-id="<?= esc($image['id']) ?>">
                                                <div class="card gallery-card shadow-sm">
                                                    <div class="card-img-actions overflow-hidden">
                                                        <img src="<?= base_url($image['image']) ?>" class="card-img-top" alt="Gallery image">
                                                        <div class="card-img-actions-overlay card-img-top d-flex align-items-end justify-content-end p-2">
                                                            <button type="button" class="btn btn-danger btn-icon btn-sm package-gallery-delete" data-image-id="<?= esc($image['id']) ?>">
                                                                <i class="ph-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="tab-pane fade" id="hotels">
                    <div class="p-3 border rounded">Coming Soon</div>
                </div>
                <div class="tab-pane fade" id="pricing">
                    <div class="p-3 border rounded">Coming Soon</div>
                </div>
                <div class="tab-pane fade" id="seo">
                    <div class="p-3 border rounded">Coming Soon</div>
                </div> -->
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('package-fact-form');
        const factIdInput = document.getElementById('fact_id');
        const factTypeSelect = document.getElementById('package_fact_type_id');
        const valueInput = document.getElementById('value');
        const sortOrderInput = document.getElementById('sort_order2');
        const statusSelect = document.getElementById('status2');
        const submitButton = document.getElementById('fact-submit-button');
        const cancelButton = document.getElementById('fact-cancel-button');
        const formTitle = document.getElementById('fact-form-title');

        function resetFactForm() {
            factIdInput.value = '';
            factTypeSelect.value = '';
            valueInput.value = '';
            sortOrderInput.value = '0';
            statusSelect.value = '1';
            submitButton.textContent = 'Add Fact';
            cancelButton.classList.add('d-none');
            formTitle.textContent = 'Add Package Fact';
        }

        document.querySelectorAll('.fact-edit-button').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                factIdInput.value = button.dataset.factId;
                factTypeSelect.value = button.dataset.factTypeId;
                valueInput.value = button.dataset.value;
                sortOrderInput.value = button.dataset.sortorder2 || '0';
                statusSelect.value = button.dataset.status2;

                submitButton.textContent = 'Update Fact';
                cancelButton.classList.remove('d-none');
                formTitle.textContent = 'Edit Package Fact';

                if (window.location.hash !== '#facts') {
                    window.location.hash = 'facts';
                }
            });
        });

        cancelButton.addEventListener('click', function() {
            resetFactForm();
        });

    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        if (window.location.hash) {

            const triggerEl = document.querySelector(
                '.nav-link[href="' + window.location.hash + '"]'
            );

            if (triggerEl) {
                new bootstrap.Tab(triggerEl).show();
            }
        }

    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadInput = document.getElementById('package-gallery-upload');
        const galleryList = document.getElementById('package-gallery-list');
        const galleryFeedback = document.getElementById('package-gallery-feedback');
        const uploadUrl = '<?= base_url('packages/images/upload/' . esc((string) $package['id'])) ?>';
        const deleteUrlBase = '<?= base_url('packages/images/delete') ?>';
        const csrfName = '<?= csrf_token() ?>';
        let csrfHash = '<?= csrf_hash() ?>';

        function showGalleryMessage(message, type = 'success') {
            galleryFeedback.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
                message +
                '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                '</div>';
        }

        function createImageCard(image) {
            const wrapper = document.createElement('div');
            wrapper.className = 'col-6 col-sm-4 col-md-3 mb-3';
            wrapper.dataset.imageId = image.id;

            wrapper.innerHTML =
                '<div class="card gallery-card shadow-sm">' +
                '<div class="card-img-actions overflow-hidden">' +
                '<img src="' + image.url + '" class="card-img-top" alt="Gallery image">' +
                '<div class="card-img-actions-overlay card-img-top d-flex align-items-end justify-content-end p-2">' +
                '<button type="button" class="btn btn-danger btn-icon btn-sm package-gallery-delete" data-image-id="' + image.id + '">' +
                '<i class="ph-trash"></i>' +
                '</button>' +
                '</div>' +
                '</div>' +
                '</div>';

            return wrapper;
        }

        function updateCsrfHash(newHash) {
            if (newHash && newHash.length) {
                csrfHash = newHash;
            }
        }

        function handleUpload(file) {
            const formData = new FormData();
            formData.append('image', file);
            formData.append(csrfName, csrfHash);

            fetch(uploadUrl, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json().then(data => ({
                    status: response.status,
                    body: data
                })))
                .then(({
                    status,
                    body
                }) => {
                    if (body.csrfHash) {
                        updateCsrfHash(body.csrfHash);
                    }

                    if (status >= 200 && status < 300 && body.success) {
                        const card = createImageCard(body.data);
                        galleryList.appendChild(card);
                        showGalleryMessage('Image uploaded successfully.');
                        attachDeleteHandlers();
                        return;
                    }

                    if (body.errors) {
                        const message = Array.isArray(body.errors) ?
                            body.errors.join('<br>') :
                            Object.values(body.errors).join('<br>');
                        showGalleryMessage(message, 'danger');
                        return;
                    }

                    showGalleryMessage('Upload failed. Please try again.', 'danger');
                })
                .catch(() => {
                    showGalleryMessage('Upload failed due to a network error.', 'danger');
                });
        }

        function attachDeleteHandlers() {
            document.querySelectorAll('.package-gallery-delete').forEach(button => {
                button.removeEventListener('click', handleDeleteButton);
                button.addEventListener('click', handleDeleteButton);
            });
        }

        function handleDeleteButton(event) {
            const button = event.currentTarget;
            const imageId = button.dataset.imageId;

            bootbox.confirm({
                title: 'Delete image?',
                message: 'Are you sure you want to delete this gallery image?',
                callback: function(result) {
                    if (!result) {
                        return;
                    }

                    fetch(deleteUrlBase + '/' + encodeURIComponent(imageId), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfHash,
                            },
                        })
                        .then(response => response.json().then(data => ({
                            status: response.status,
                            body: data
                        })))
                        .then(({
                            status,
                            body
                        }) => {
                            if (body.csrfHash) {
                                updateCsrfHash(body.csrfHash);
                            }

                            if (status >= 200 && status < 300 && body.success) {
                                const card = galleryList.querySelector('[data-image-id="' + imageId + '"]');
                                if (card) {
                                    card.remove();
                                }
                                showGalleryMessage('Image deleted successfully.');
                                return;
                            }

                            const message = body.errors ?
                                Object.values(body.errors).join('<br>') :
                                'Delete failed. Please try again.';
                            showGalleryMessage(message, 'danger');
                        })
                        .catch(() => {
                            showGalleryMessage('Delete failed due to a network error.', 'danger');
                        });
                }
            });
        }

        if (uploadInput) {
            uploadInput.addEventListener('change', function() {
                const files = Array.from(uploadInput.files || []);
                if (!files.length) {
                    return;
                }

                files.forEach(handleUpload);
                uploadInput.value = '';
            });
        }

        function setupMediaPreview(inputId, previewId, placeholderId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);

            if (!input || !preview) {
                return;
            }

            input.addEventListener('change', function() {
                const file = input.files && input.files[0];
                if (!file) {
                    return;
                }

                if (!/^image\/(jpeg|jpg|png|webp)$/i.test(file.type)) {
                    return;
                }

                const objectUrl = URL.createObjectURL(file);

                preview.src = objectUrl;
                preview.classList.remove('d-none');

                if (placeholder) {
                    placeholder.classList.add('d-none');
                }
            });
        }

        setupMediaPreview('featured_image', 'featured_image_preview', 'featured_image_placeholder');
        setupMediaPreview('banner_image', 'banner_image_preview', 'banner_image_placeholder');

        attachDeleteHandlers();
    });
</script>
<?= $this->endSection() ?>
