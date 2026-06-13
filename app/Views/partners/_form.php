<?php
$partner = $partner ?? [];
$isEdit = ! empty($partner);
$action = $isEdit ? base_url('partners/update/' . $partner['id']) : base_url('partners/store');
$buttonText = $isEdit ? 'Update Partner' : 'Create Partner';
$currentLogo = $partner['logo'] ?? '';
?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= $action ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= esc(old('name', $partner['name'] ?? '')) ?>" required>
                <?php if (session('errors.name')): ?>
                    <div class="invalid-feedback"><?= esc(session('errors.name')) ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="website_url" class="form-label">Website URL</label>
                <input type="url" class="form-control <?= session('errors.website_url') ? 'is-invalid' : '' ?>" id="website_url" name="website_url" value="<?= esc(old('website_url', $partner['website_url'] ?? '')) ?>" placeholder="https://example.com">
                <?php if (session('errors.website_url')): ?>
                    <div class="invalid-feedback"><?= esc(session('errors.website_url')) ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="form-group mb-3">
        <label class="form-label d-block">Logo <?= $isEdit ? '' : '<span class="text-danger">*</span>' ?></label>
        <div class="card border-dashed p-3 mb-3">
            <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                <div class="rounded overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width:180px; height:110px;">
                    <img id="partner_logo_preview" src="<?= ! empty($currentLogo) ? base_url($currentLogo) : '' ?>" alt="Partner logo" class="img-fluid <?= empty($currentLogo) ? 'd-none' : '' ?>" style="max-height:90px; object-fit:contain;">
                    <div id="partner_logo_placeholder" class="text-muted <?= ! empty($currentLogo) ? 'd-none' : '' ?>">
                        Logo preview
                    </div>
                </div>
                <div class="flex-fill">
                    <div class="mb-2">
                        <label for="partner_logo" class="btn btn-outline-primary btn-sm">
                            <i class="ph-upload me-1"></i> Choose logo
                        </label>
                        <input type="file" id="partner_logo" name="logo" accept=".jpg,.jpeg,.png,.webp" class="d-none" <?= $isEdit ? '' : 'required' ?>>
                    </div>
                    <?php if ($isEdit): ?>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="delete_current_logo" name="delete_current_logo" value="1" <?= old('delete_current_logo') === '1' ? 'checked' : '' ?>>
                            <label class="form-check-label" for="delete_current_logo">Delete current image</label>
                        </div>
                    <?php endif; ?>
                    <p class="text-muted mb-1">JPG, JPEG, PNG or WEBP. Max 4MB.</p>
                    <?php if (session('errors.logo')): ?>
                        <div class="text-danger small"><?= esc(session('errors.logo')) ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="sort_order" class="form-label">Sort Order</label>
                <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= esc(old('sort_order', $partner['sort_order'] ?? 0)) ?>">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control form-control-select2" data-minimum-results-for-search="Infinity" id="status" name="status">
                    <option value="1" <?= old('status', (string) ($partner['status'] ?? '1')) === '1' ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= old('status', (string) ($partner['status'] ?? '1')) === '0' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-success">
            <i class="icon-check"></i> <?= $buttonText ?>
        </button>
        <a href="<?= base_url('partners') ?>" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('partner_logo');
        const preview = document.getElementById('partner_logo_preview');
        const placeholder = document.getElementById('partner_logo_placeholder');

        if (!input || !preview) {
            return;
        }

        input.addEventListener('change', function() {
            const file = input.files && input.files[0];
            if (!file || !/^image\/(jpeg|jpg|png|webp)$/i.test(file.type)) {
                return;
            }

            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');

            if (placeholder) {
                placeholder.classList.add('d-none');
            }
        });
    });
</script>
