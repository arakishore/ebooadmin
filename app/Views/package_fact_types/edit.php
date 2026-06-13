<?php /** @var array<string,mixed> $package_fact_type */ ?>

<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('package_fact_types') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">Package Fact Type</a>
                <span class="breadcrumb-item active">Edit Package Fact Type</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        <div class="collapse d-lg-block ms-lg-auto" id="breadcrumb_elements">
            <div class="d-lg-flex mb-2 mb-lg-0">
                <a href="<?= base_url('package_fact_types') ?>" class="d-flex align-items-center text-body py-2">
                    <i class="icon-arrow-left7 me-2"></i>
                    Back to Package Fact Types List
                </a>


            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title"> Edit Package Fact Type </h6>
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

            <form action="<?= base_url('package_fact_types/update/' . esc((string) $package_fact_type['id'])) ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= esc((string) $package_fact_type['id']) ?>">

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>

                    <input type="text"
                        class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>"
                        id="name"
                        name="name"
                        value="<?= esc(old('name', $package_fact_type['name'])) ?>"
                        placeholder="e.g., Fact Name"
                        required>
                    <?php if (session('errors.name')): ?>
                        <div class="invalid-feedback"><?= session('errors.name') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control <?= session('errors.slug') ? 'is-invalid' : '' ?>" id="slug" name="slug" value="<?= old('slug', esc($package_fact_type['slug'])) ?>" placeholder="Leave empty to auto-generate from name">
                    <small class="text-muted">Leave empty to auto-generate from the name</small>
                    <?php if (session('errors.slug')): ?>
                        <div class="invalid-feedback"><?= session('errors.slug') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter package fact type description"><?= old('description', esc($package_fact_type['description'] ?? '')) ?></textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="icon" class="form-label">Icon</label>
                    <input type="text" class="form-control" id="icon" name="icon" value="<?= old('icon', esc((string) ($package_fact_type['icon'] ?? ''))) ?>" placeholder="e.g., icon-class or icon name">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order', $package_fact_type['sort_order']) ?>" placeholder="0">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-control form-control-select2" data-minimum-results-for-search="Infinity" id="status" name="status" required>
                                <option value="1" <?= old('status', $package_fact_type['status']) == 1 ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= old('status', $package_fact_type['status']) == 0 ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="icon-check"></i> Update Package Fact Type
                    </button>
                    <a href="<?= base_url('package_fact_types') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
