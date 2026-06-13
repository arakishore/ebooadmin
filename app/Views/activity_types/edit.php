<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('activity_types') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">Activity Type</a>
                <span class="breadcrumb-item active">Edit Activity Type</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        <div class="collapse d-lg-block ms-lg-auto" id="breadcrumb_elements">
            <div class="d-lg-flex mb-2 mb-lg-0">
                <a href="<?= base_url('activity_types') ?>" class="d-flex align-items-center text-body py-2">
                    <i class="icon-arrow-left7 me-2"></i>
                    Back to Activity Types List
                </a>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title"> Edit Activity Type </h6>
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

            <form action="<?= base_url('activity_types/update/' . $activity_type['id']) ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= esc($activity_type['id']) ?>">

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= esc(old('name', $activity_type['name'])) ?>" placeholder="e.g., Adventure" required>
                    <?php if (session('errors.name')): ?>
                        <div class="invalid-feedback"><?= session('errors.name') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control <?= session('errors.slug') ? 'is-invalid' : '' ?>" id="slug" name="slug" value="<?= esc(old('slug', $activity_type['slug'])) ?>" placeholder="Leave empty to auto-generate from name">
                    <small class="text-muted">Leave empty to auto-generate from the name</small>
                    <?php if (session('errors.slug')): ?>
                        <div class="invalid-feedback"><?= session('errors.slug') ?></div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="icon" class="form-label">Icon</label>
                            <input type="text" class="form-control" id="icon" name="icon" value="<?= esc(old('icon', $activity_type['icon'] ?? '')) ?>" placeholder="e.g., icon-skiing">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control <?= session('errors.sort_order') ? 'is-invalid' : '' ?>" id="sort_order" name="sort_order" value="<?= esc(old('sort_order', $activity_type['sort_order'] ?? 0)) ?>" placeholder="0">
                            <?php if (session('errors.sort_order')): ?>
                                <div class="invalid-feedback"><?= session('errors.sort_order') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-control form-control-select2" id="status" name="status" data-minimum-results-for-search="Infinity" required>
                        <option value="1" <?= old('status', $activity_type['status']) == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= old('status', $activity_type['status']) == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="icon-check"></i> Update Activity Type
                    </button>
                    <a href="<?= base_url('activity_types') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
