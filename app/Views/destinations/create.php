<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('destinations') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">Destination</a>
                <span class="breadcrumb-item active">Add Destination</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        <div class="collapse d-lg-block ms-lg-auto" id="breadcrumb_elements">
            <div class="d-lg-flex mb-2 mb-lg-0">
                <a href="<?= base_url('destinations') ?>" class="d-flex align-items-center text-body py-2">
                    <i class="icon-arrow-left7 me-2"></i>
                    Back to Destinations List
                </a>


            </div>
        </div>
    </div>
</div>
<div class="content">

    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title"> Add Destination </h6>
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

            <form action="<?= base_url('destinations/store') ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>" id="name" name="name" value="<?= old('name') ?>" placeholder="e.g., Dubai" required>
                    <?php if (session('errors.name')): ?>
                        <div class="invalid-feedback"><?= session('errors.name') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control <?= session('errors.slug') ? 'is-invalid' : '' ?>" id="slug" name="slug" value="<?= old('slug') ?>" placeholder="Leave empty to auto-generate from name">
                    <small class="text-muted">Leave empty to auto-generate from the name</small>
                    <?php if (session('errors.slug')): ?>
                        <div class="invalid-feedback"><?= session('errors.slug') ?></div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="<?= old('country') ?>" placeholder="e.g., United Arab Emirates">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="<?= old('city') ?>" placeholder="e.g., Dubai">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter destination description"><?= old('description') ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label d-block">Destination Image</label>
                            <div class="card border-dashed p-3 mb-3">
                                <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                                    <div class="rounded overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width:180px; height:120px;">
                                        <img id="destination_image_preview" src="" alt="Destination image" class="img-fluid d-none" style="width:100%; height:100%; object-fit:cover;">
                                        <div id="destination_image_placeholder" class="text-muted">Thumbnail</div>
                                    </div>
                                    <div class="flex-fill">
                                        <label for="destination_image" class="btn btn-outline-primary btn-sm">
                                            <i class="ph-upload me-1"></i> Choose image
                                        </label>
                                        <input type="file" id="destination_image" name="image" accept=".jpg,.jpeg,.png,.webp" class="d-none">
                                        <p class="text-muted mb-1 mt-2">JPG, JPEG, PNG or WEBP. Max 4MB.</p>
                                        <?php if (session('errors.image')): ?>
                                            <div class="text-danger small"><?= session('errors.image') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label d-block">Banner Image</label>
                            <div class="card border-dashed p-3 mb-3">
                                <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                                    <div class="rounded overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width:220px; height:120px;">
                                        <img id="destination_banner_preview" src="" alt="Destination banner image" class="img-fluid d-none" style="width:100%; height:100%; object-fit:cover;">
                                        <div id="destination_banner_placeholder" class="text-muted">Banner</div>
                                    </div>
                                    <div class="flex-fill">
                                        <label for="destination_banner_image" class="btn btn-outline-primary btn-sm">
                                            <i class="ph-upload me-1"></i> Choose banner
                                        </label>
                                        <input type="file" id="destination_banner_image" name="banner_image" accept=".jpg,.jpeg,.png,.webp" class="d-none">
                                        <p class="text-muted mb-1 mt-2">JPG, JPEG, PNG or WEBP. Max 4MB.</p>
                                        <?php if (session('errors.banner_image')): ?>
                                            <div class="text-danger small"><?= session('errors.banner_image') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="sort_order" class="form-label">Sort Order</label>
                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= old('sort_order', 0) ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-control form-control-select2" data-minimum-results-for-search="Infinity" id="status" name="status" required>
                        <option value="1" <?= old('status') == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= old('status') == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="icon-check"></i> Create Destination
                    </button>
                    <a href="<?= base_url('destinations') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function setupImagePreview(inputId, previewId, placeholderId) {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);

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
        }

        setupImagePreview('destination_image', 'destination_image_preview', 'destination_image_placeholder');
        setupImagePreview('destination_banner_image', 'destination_banner_preview', 'destination_banner_placeholder');
    });
</script>
<?= $this->endSection() ?>
