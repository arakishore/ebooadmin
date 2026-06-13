<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('packages') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">Package</a>
                <span class="breadcrumb-item active">Add Package</span>
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

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title"> Add Package </h6>
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

            <form action="<?= base_url('packages/store') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="destination_id" class="form-label">Destination <span class="text-danger">*</span></label>
                            <select class="form-control select <?= session('errors.destination_id') ? 'is-invalid' : '' ?>" id="destination_id" name="destination_id" required>
                                <option value="">Select destination</option>
                                <?php foreach ($destinations as $destination): ?>
                                    <option value="<?= esc($destination['id']) ?>" <?= old('destination_id') == $destination['id'] ? 'selected' : '' ?>><?= esc($destination['name']) ?></option>
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
                            <?php $selectedCategoryIds = array_map('intval', (array) old('package_category_ids', [])); ?>
                            <select class="form-control form-control-select2 <?= session('errors.package_category_ids') ? 'is-invalid' : '' ?>" id="package_category_ids" name="package_category_ids[]" multiple="multiple" data-placeholder="Select categories" required>
                                <?php foreach ($packageCategories as $category): ?>
                                    <option value="<?= esc($category['id']) ?>" <?= in_array((int) $category['id'], $selectedCategoryIds, true) ? 'selected' : '' ?>><?= esc($category['name']) ?></option>
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
                                    <option value="<?= esc($hotelCategory['id']) ?>" <?= old('hotel_category_id') == $hotelCategory['id'] ? 'selected' : '' ?>><?= esc($hotelCategory['name']) ?></option>
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
                                    <option value="<?= esc($mealPlanType['id']) ?>" <?= old('meal_plan_type_id') == $mealPlanType['id'] ? 'selected' : '' ?>><?= esc($mealPlanType['name']) ?></option>
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
                                    <option value="<?= esc($transportType['id']) ?>" <?= old('transport_type_id') == $transportType['id'] ? 'selected' : '' ?>><?= esc($transportType['name']) ?></option>
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
                    <input type="text" class="form-control <?= session('errors.title') ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= old('title') ?>" placeholder="Enter package title" required>
                    <?php if (session('errors.title')): ?>
                        <div class="invalid-feedback"><?= session('errors.title') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control <?= session('errors.slug') ? 'is-invalid' : '' ?>" id="slug" name="slug" value="<?= old('slug') ?>" placeholder="Leave empty to auto-generate from title">
                    <small class="text-muted">Leave empty to auto-generate from the title</small>
                    <?php if (session('errors.slug')): ?>
                        <div class="invalid-feedback"><?= session('errors.slug') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="short_description" class="form-label">Short Description</label>
                    <textarea class="form-control <?= session('errors.short_description') ? 'is-invalid' : '' ?>" id="short_description" name="short_description" rows="3" placeholder="Enter short description"><?= old('short_description') ?></textarea>
                    <?php if (session('errors.short_description')): ?>
                        <div class="invalid-feedback"><?= session('errors.short_description') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control <?= session('errors.description') ? 'is-invalid' : '' ?>" id="description" name="description" rows="5" placeholder="Enter package description"><?= old('description') ?></textarea>
                    <?php if (session('errors.description')): ?>
                        <div class="invalid-feedback"><?= session('errors.description') ?></div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="duration_days" class="form-label">Duration Days <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?= session('errors.duration_days') ? 'is-invalid' : '' ?>" id="duration_days" name="duration_days" value="<?= old('duration_days', 1) ?>" min="1" required>
                            <?php if (session('errors.duration_days')): ?>
                                <div class="invalid-feedback"><?= session('errors.duration_days') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="duration_nights" class="form-label">Duration Nights <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?= session('errors.duration_nights') ? 'is-invalid' : '' ?>" id="duration_nights" name="duration_nights" value="<?= old('duration_nights', 0) ?>" min="0" required>
                            <?php if (session('errors.duration_nights')): ?>
                                <div class="invalid-feedback"><?= session('errors.duration_nights') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="starting_price" class="form-label">Starting Price <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control <?= session('errors.starting_price') ? 'is-invalid' : '' ?>" id="starting_price" name="starting_price" value="<?= old('starting_price', '0.00') ?>" required>
                            <?php if (session('errors.starting_price')): ?>
                                <div class="invalid-feedback"><?= session('errors.starting_price') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="sale_price" class="form-label">Sale Price</label>
                            <input type="number" step="0.01" class="form-control <?= session('errors.sale_price') ? 'is-invalid' : '' ?>" id="sale_price" name="sale_price" value="<?= old('sale_price', '0.00') ?>">
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
                                <option value="1" <?= old('is_featured') == 1 ? 'selected' : '' ?>>Yes</option>
                                <option value="0" <?= old('is_featured') == 0 ? 'selected' : '' ?>>No</option>
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
                                <option value="1" <?= old('status') == 1 ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= old('status') == 0 ? 'selected' : '' ?>>Inactive</option>
                            </select>
                            <?php if (session('errors.status')): ?>
                                <div class="invalid-feedback"><?= session('errors.status') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control <?= session('errors.sort_order') ? 'is-invalid' : '' ?>" id="sort_order" name="sort_order" value="<?= old('sort_order', 0) ?>">
                            <?php if (session('errors.sort_order')): ?>
                                <div class="invalid-feedback"><?= session('errors.sort_order') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control <?= session('errors.meta_title') ? 'is-invalid' : '' ?>" id="meta_title" name="meta_title" value="<?= old('meta_title') ?>">
                    <?php if (session('errors.meta_title')): ?>
                        <div class="invalid-feedback"><?= session('errors.meta_title') ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group mb-3">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" class="form-control <?= session('errors.meta_keywords') ? 'is-invalid' : '' ?>" id="meta_keywords" name="meta_keywords" value="<?= old('meta_keywords') ?>">
                    <?php if (session('errors.meta_keywords')): ?>
                        <div class="invalid-feedback"><?= session('errors.meta_keywords') ?></div>
                    <?php endif; ?>
                    <div class="form-text">comma-separated</div>
                </div>

                <div class="form-group mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control <?= session('errors.meta_description') ? 'is-invalid' : '' ?>" id="meta_description" name="meta_description" rows="3"><?= old('meta_description') ?></textarea>
                    <?php if (session('errors.meta_description')): ?>
                        <div class="invalid-feedback"><?= session('errors.meta_description') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="icon-check"></i> Create Package
                    </button>
                    <a href="<?= base_url('packages') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
