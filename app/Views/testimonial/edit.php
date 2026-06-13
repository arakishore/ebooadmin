<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>
<?php $testimonial = $testimonial ?? []; ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="<?= base_url('testimonials') ?>" class="breadcrumb-item">Testimonials</a>
                <span class="breadcrumb-item active">Edit Testimonial</span>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Edit Testimonial</h6>
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

            <form action="<?= base_url('testimonials/update/' . ($testimonial['id'] ?? 0)) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= esc(old('name', $testimonial['name'] ?? '')) ?>" required>
                            <?php if (session('errors.name')): ?>
                                <div class="invalid-feedback"><?= session('errors.name') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designation" name="designation" value="<?= esc(old('designation', $testimonial['designation'] ?? '')) ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="company" name="company" value="<?= esc(old('company', $testimonial['company'] ?? '')) ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location" value="<?= esc(old('location', $testimonial['location'] ?? '')) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label d-block">Testimonial Image</label>
                    <div class="card border-dashed p-3 mb-3">
                        <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                            <div class="ratio ratio-16x9 rounded overflow-hidden bg-light" style="min-width:160px; max-width:240px;">
                                <img id="testimonial_image_preview" src="<?= ! empty($testimonial['image'] ?? null) ? base_url($testimonial['image']) : '' ?>" alt="Testimonial image" class="img-fluid rounded <?= empty($testimonial['image'] ?? null) ? 'd-none' : '' ?>">
                                <div id="testimonial_image_placeholder" class="d-flex align-items-center justify-content-center h-100 text-muted <?= ! empty($testimonial['image'] ?? null) ? 'd-none' : '' ?>">
                                    Testimonial image
                                </div>
                            </div>
                            <div class="flex-fill">
                                <label class="form-label d-block">Testimonial Image</label>
                                <div class="mb-2">
                                    <label for="testimonial_image" class="btn btn-outline-primary btn-sm">
                                        <i class="ph-upload me-1"></i> Choose testimonial image
                                    </label>
                                    <input type="file" id="testimonial_image" name="image" accept=".jpg,.jpeg,.png,.webp" class="d-none">
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="delete_current_image" name="delete_current_image" value="1" <?= old('delete_current_image') === '1' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="delete_current_image">Delete current image</label>
                                </div>
                                <p class="text-muted mb-1">Recommended size: original upload. JPG, JPEG, PNG or WEBP. Max 4MB.</p>
                                <?php if (session('errors.image')): ?>
                                    <div class="text-danger small"><?= session('errors.image') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
                            <select class="form-control form-control-select2" data-minimum-results-for-search="Infinity" id="rating" name="rating">
                                <option value="4" <?= old('rating', (string) ($testimonial['rating'] ?? 5)) === '4' ? 'selected' : '' ?>>4</option>
                                <option value="5" <?= old('rating', (string) ($testimonial['rating'] ?? 5)) === '5' ? 'selected' : '' ?>>5</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="featured" class="form-label">Featured</label>
                            <select class="form-control form-control-select2" data-minimum-results-for-search="Infinity" id="featured" name="featured">
                                <option value="0" <?= old('featured', (string) ($testimonial['featured'] ?? 0)) === '0' ? 'selected' : '' ?>>No</option>
                                <option value="1" <?= old('featured', (string) ($testimonial['featured'] ?? 0)) === '1' ? 'selected' : '' ?>>Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= esc(old('sort_order', $testimonial['sort_order'] ?? 0)) ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                    <textarea class="form-control <?= session('errors.message') ? 'is-invalid' : '' ?>" id="message" name="message" rows="5" placeholder="Enter testimonial message" required><?= esc(old('message', $testimonial['message'] ?? '')) ?></textarea>
                    <?php if (session('errors.message')): ?>
                        <div class="invalid-feedback"><?= session('errors.message') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control form-control-select2" data-minimum-results-for-search="Infinity" id="status" name="status">
                        <option value="1" <?= old('status', (string) ($testimonial['status'] ?? '1')) === '1' ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= old('status', (string) ($testimonial['status'] ?? '0')) === '0' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="icon-check"></i> Update Testimonial
                    </button>
                    <a href="<?= base_url('testimonials') ?>" class="btn btn-secondary">Cancel</a>
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

        setupMediaPreview('testimonial_image', 'testimonial_image_preview', 'testimonial_image_placeholder');
    });
</script>

<?= $this->endSection() ?>
