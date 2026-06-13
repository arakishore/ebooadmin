<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="<?= base_url('faq-categories') ?>" class="breadcrumb-item">FAQ Categories</a>
                <span class="breadcrumb-item active">Create FAQ Category</span>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('faq-categories/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" value="<?= esc(old('name')) ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" value="<?= esc(old('slug')) ?>" class="form-control">
                    <div class="form-text">Leave blank to auto-generate.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" value="<?= esc(old('sort_order')) ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= old('status', '1') === '1' ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= old('status') === '0' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="icon-check"></i> Save FAQ Category
                    </button>
                    <a href="<?= base_url('faq-categories') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
