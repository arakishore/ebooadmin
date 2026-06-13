<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('destinations') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">Destination</a>
                <span class="breadcrumb-item active">Edit Destination</span>
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
            <h6 class="card-title"> Edit Destination </h6>
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
                <li class="nav-item"><a href="#gallery" class="nav-link" data-bs-toggle="tab">Gallery</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="basic-info">
            <form action="<?= base_url('destinations/update/' . $destination['id']) ?>" method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <input type="hidden" name="id" value="<?= esc($destination['id']) ?>">

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>

                    <input type="text"
                        class="form-control <?= session('errors.name') ? 'is-invalid' : '' ?>"
                        id="name"
                        name="name"
                        value="<?= esc(old('name', $destination['name'])) ?>"
                        placeholder="e.g., Dubai"
                        required>
                    <?php if (session('errors.name')): ?>
                        <div class="invalid-feedback"><?= session('errors.name') ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control <?= session('errors.slug') ? 'is-invalid' : '' ?>" id="slug" name="slug" value="<?= old('slug', esc($destination['slug'])) ?>" placeholder="Leave empty to auto-generate from name">
                    <small class="text-muted">Leave empty to auto-generate from the name</small>
                    <?php if (session('errors.slug')): ?>
                        <div class="invalid-feedback"><?= session('errors.slug') ?></div>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country" value="<?= old('country', esc($destination['country'] ?? '')) ?>" placeholder="e.g., United Arab Emirates">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="<?= old('city', esc($destination['city'] ?? '')) ?>" placeholder="e.g., Dubai">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter destination description"><?= old('description', esc($destination['description'] ?? '')) ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label d-block">Destination Image</label>
                            <div class="card border-dashed p-3 mb-3">
                                <div class="d-flex flex-column flex-sm-row align-items-start gap-3">
                                    <div class="rounded overflow-hidden bg-light border d-flex align-items-center justify-content-center" style="width:180px; height:120px;">
                                        <img id="destination_image_preview" src="<?= ! empty($destination['image'] ?? null) ? base_url($destination['image']) : '' ?>" alt="Destination image" class="img-fluid <?= empty($destination['image'] ?? null) ? 'd-none' : '' ?>" style="width:100%; height:100%; object-fit:cover;">
                                        <div id="destination_image_placeholder" class="text-muted <?= ! empty($destination['image'] ?? null) ? 'd-none' : '' ?>">Thumbnail</div>
                                    </div>
                                    <div class="flex-fill">
                                        <label for="destination_image" class="btn btn-outline-primary btn-sm">
                                            <i class="ph-upload me-1"></i> Choose image
                                        </label>
                                        <input type="file" id="destination_image" name="image" accept=".jpg,.jpeg,.png,.webp" class="d-none">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="delete_current_image" name="delete_current_image" value="1" <?= old('delete_current_image') === '1' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="delete_current_image">Delete current image</label>
                                        </div>
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
                                        <img id="destination_banner_preview" src="<?= ! empty($destination['banner_image'] ?? null) ? base_url($destination['banner_image']) : '' ?>" alt="Destination banner image" class="img-fluid <?= empty($destination['banner_image'] ?? null) ? 'd-none' : '' ?>" style="width:100%; height:100%; object-fit:cover;">
                                        <div id="destination_banner_placeholder" class="text-muted <?= ! empty($destination['banner_image'] ?? null) ? 'd-none' : '' ?>">Banner</div>
                                    </div>
                                    <div class="flex-fill">
                                        <label for="destination_banner_image" class="btn btn-outline-primary btn-sm">
                                            <i class="ph-upload me-1"></i> Choose banner
                                        </label>
                                        <input type="file" id="destination_banner_image" name="banner_image" accept=".jpg,.jpeg,.png,.webp" class="d-none">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input" type="checkbox" id="delete_current_banner_image" name="delete_current_banner_image" value="1" <?= old('delete_current_banner_image') === '1' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="delete_current_banner_image">Delete current image</label>
                                        </div>
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
                    <input type="number" class="form-control" id="sort_order" name="sort_order" value="<?= esc(old('sort_order', $destination['sort_order'] ?? 0)) ?>">
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                    <select class="form-control form-control-select2" data-minimum-results-for-search="Infinity" id="status" name="status" required>
                        <option value="1" <?= old('status', $destination['status']) == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= old('status', $destination['status']) == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="icon-check"></i> Update Destination
                    </button>
                    <a href="<?= base_url('destinations') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
                </div>
                <div class="tab-pane fade" id="gallery">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                    <div>
                                        <h6 class="card-title">Destination Gallery</h6>
                                        <span class="text-muted d-block">Upload multiple gallery images and manage them without page reload.</span>
                                    </div>
                                    <div>
                                        <label for="destination-gallery-upload" class="btn btn-primary btn-sm">
                                            <i class="ph-upload me-1"></i> Select Images
                                        </label>
                                        <input type="file" id="destination-gallery-upload" class="d-none" accept=".jpg,.jpeg,.png,.webp" multiple>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="destination-gallery-feedback"></div>
                                    <div class="row" id="destination-gallery-list">
                                        <?php foreach (($destinationImages ?? []) as $image): ?>
                                            <div class="col-6 col-sm-4 col-md-3 mb-3" data-image-id="<?= esc($image['id']) ?>">
                                                <div class="card gallery-card shadow-sm">
                                                    <div class="card-img-actions overflow-hidden">
                                                        <img src="<?= base_url($image['image']) ?>" class="card-img-top" alt="Gallery image">
                                                        <div class="card-img-actions-overlay card-img-top d-flex align-items-end justify-content-end p-2">
                                                            <button type="button" class="btn btn-danger btn-icon btn-sm destination-gallery-delete" data-image-id="<?= esc($image['id']) ?>">
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
            </div>
        </div>
    </div>
</div>
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
        const uploadInput = document.getElementById('destination-gallery-upload');
        const galleryList = document.getElementById('destination-gallery-list');
        const galleryFeedback = document.getElementById('destination-gallery-feedback');
        const uploadUrl = '<?= base_url('destinations/images/upload/' . esc((string) $destination['id'])) ?>';
        const deleteUrlBase = '<?= base_url('destinations/images/delete') ?>';
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
                '<button type="button" class="btn btn-danger btn-icon btn-sm destination-gallery-delete" data-image-id="' + image.id + '">' +
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
            document.querySelectorAll('.destination-gallery-delete').forEach(button => {
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

        attachDeleteHandlers();
    });
</script>
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
