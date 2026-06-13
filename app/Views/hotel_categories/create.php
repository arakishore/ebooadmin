<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('hotel_categories') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">Hotel Category</a>
                <span class="breadcrumb-item active">Add Hotel Category</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        <div class="collapse d-lg-block ms-lg-auto" id="breadcrumb_elements">
            <div class="d-lg-flex mb-2 mb-lg-0">
                <a href="<?= base_url('hotel_categories') ?>" class="d-flex align-items-center text-body py-2">
                    <i class="icon-arrow-left7 me-2"></i>
                    Back to Hotel Categories List
                </a>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title"> Add Hotel Category </h6>
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

            <form action="<?= base_url('hotel_categories/store') ?>" method="POST">
                <?= csrf_field() ?>

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name') ?>" placeholder="e.g., 5 Star Luxury" required>
                    <?php if (session('errors.name')): ?>
                        <div class="invalid-feedback"><?= session('errors.name') ?></div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="stars" class="form-label">Stars <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?= session('errors.stars') ? 'is-invalid' : '' ?>" id="stars" name="stars" value="<?= old('stars', 3) ?>" min="1" max="5" required>
                            <?php if (session('errors.stars')): ?>
                                <div class="invalid-feedback"><?= session('errors.stars') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control <?= session('errors.slug') ? 'is-invalid' : '' ?>" id="slug" name="slug" value="<?= old('slug') ?>" placeholder="Leave empty to auto-generate from name">
                            <small class="text-muted">Leave empty to auto-generate from the name</small>
                            <?php if (session('errors.slug')): ?>
                                <div class="invalid-feedback"><?= session('errors.slug') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter category description"><?= old('description') ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="text" class="form-control" id="icon" name="icon" value="<?= old('icon') ?>" placeholder="e.g., icon-hotel">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-control form-control-select2" data-minimum-results-for-search="Infinity" id="status" name="status" required>
                                <option value="1" <?= old('status') == 1 ? 'selected' : '' ?>>Active</option>
                                <option value="0" <?= old('status') == 0 ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="icon-check"></i> Create Hotel Category
                    </button>
                    <a href="<?= base_url('hotel_categories') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
