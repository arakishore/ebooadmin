<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="<?= base_url('banners') ?>" class="breadcrumb-item">Banners</a>
                <span class="breadcrumb-item active">Edit Banner</span>
            </div>
        </div>
    </div>
</div>

<div class="content">

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title"> Edit Banner </h6>
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

            <form action="<?= base_url('banners/update/' . $banner['id']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="form-group mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= session('errors.title') ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= esc(old('title', $banner['title'])) ?>" required>
                    <?php if (session('errors.title')): ?>
                        <div class="invalid-feedback"><?= session('errors.title') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="subtitle" class="form-label">Subtitle</label>
                    <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?= esc(old('subtitle', $banner['subtitle'])) ?>">
                </div>

                <div class="form-group mb-3">
                    <label class="form-label d-block">Banner Image</label>
                    <div class="card border-dashed p-3 mb-3">
                        <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                            <div class="ratio ratio-16x9 rounded overflow-hidden bg-light" style="min-width:160px; max-width:240px;">
                                <img id="banner_image_preview" src="<?= ! empty($banner['image']) ? base_url($banner['image']) : '' ?>" alt="Banner image" class="img-fluid rounded <?= empty($banner['image']) ? 'd-none' : '' ?>">
                                <div id="banner_image_placeholder" class="d-flex align-items-center justify-content-center h-100 text-muted <?= ! empty($banner['image']) ? 'd-none' : '' ?>">
                                    Banner image
                                </div>
                            </div>
                            <div class="flex-fill">
                                <label class="form-label d-block">Banner Image</label>
                                <div class="mb-2">
                                    <label for="banner_image" class="btn btn-outline-primary btn-sm">
                                        <i class="ph-upload me-1"></i> Choose banner image
                                    </label>
                                    <input type="file" id="banner_image" name="image" accept=".jpg,.jpeg,.png,.webp" class="d-none">
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="delete_current_image" name="delete_current_image" value="1" <?= old('delete_current_image') === '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="delete_current_image">Delete current image</label>
                                </div>
                                <p class="text-muted mb-1">Recommended size: 1200x400. JPG, JPEG, PNG or WEBP. Max 4MB.</p>
                                <?php if (session('errors.image')): ?>
                                    <div class="text-danger small"><?= session('errors.image') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="button_text" class="form-label">Button Text</label>
                            <input type="text" class="form-control" id="button_text" name="button_text" value="<?= esc(old('button_text', $banner['button_text'])) ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="button_url" class="form-label">Button URL</label>
                            <input type="text" class="form-control" id="button_url" name="button_url" value="<?= esc(old('button_url', $banner['button_url'])) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="page" class="form-label">For Page</label>
                    <?php $selectedPage = old('page', $banner['page'] ?? 'home'); ?>

                    <select
                        class="form-control form-control-select2"
                        id="page"
                        name="page"
                        data-minimum-results-for-search="Infinity"
                        required>
                        <option value="home" <?= $selectedPage === 'home' ? 'selected' : '' ?>>Home Page</option>
                        <option value="hotel" <?= $selectedPage === 'hotel' ? 'selected' : '' ?>>Hotel Service Page</option>
                        <option value="car" <?= $selectedPage === 'car' ? 'selected' : '' ?>>Car Service Page</option>
                        <option value="forex" <?= $selectedPage === 'forex' ? 'selected' : '' ?>>Forex Service Page</option>
                        <option value="visa" <?= $selectedPage === 'visa' ? 'selected' : '' ?>>Visa Service Page</option>
                        <option value="flights" <?= $selectedPage === 'flights' ? 'selected' : '' ?>>Flights Service Page</option>
                        <option value="cruise" <?= $selectedPage === 'cruise' ? 'selected' : '' ?>>Cruise Service Page</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= esc(old('sort_order', $banner['sort_order'] ?? 0)) ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control form-control-select2" data-minimum-results-for-search="Infinity" id="status" name="status">
                        <option value="1" <?= old('status', (string) ($banner['status'] ?? '1')) === '1' ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= old('status', (string) ($banner['status'] ?? '0')) === '0' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="icon-check"></i> Update Banner
                    </button>
                    <a href="<?= base_url('banners') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        setupMediaPreview('banner_image', 'banner_image_preview', 'banner_image_placeholder');
    });
</script>

<?= $this->endSection() ?>