<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <span class="breadcrumb-item active">Gallery</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Gallery</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('gallery') ?>" method="GET" class="mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="gallery_type" class="form-label">Gallery Type</label>
                        <select class="form-control form-control-select2" data-minimum-results-for-search="Infinity" id="gallery_type" name="gallery_type">
                             <option value="all" <?= $selectedType === 'all' ? 'selected' : '' ?>>All</option>
                            <?php foreach ($galleryTypes as $value => $label): ?>
                                <option value="<?= esc($value) ?>" <?= $selectedType === $value ? 'selected' : '' ?>>
                                    <?= esc($label) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-success">
                            <i class="icon-check"></i> Show Images
                        </button>
                    </div>

                    <div class="col-md-auto ms-md-auto">
                        <label for="gallery-upload" class="btn btn-primary mb-0">
                            <i class="ph-upload me-1"></i> Select Images
                        </label>
                        <input type="file" id="gallery-upload" class="d-none" accept=".jpg,.jpeg,.png,.webp" multiple>
                    </div>
                </div>
            </form>

            <div id="gallery-feedback"></div>

            <div class="row" id="gallery-list">
                <?php foreach (($galleryImages ?? []) as $image): ?>
                    <div class="col-6 col-sm-4 col-md-3 mb-3" data-image-id="<?= esc($image['id']) ?>">
                        
                        <div class="card gallery-card shadow-sm">
                            
                            <div class="card-img-actions overflow-hidden">
                                
                                <img src="<?= base_url($image['image']) ?>" class="card-img-top" alt="Gallery image">
                                <span class="badge bg-dark bg-opacity-75 position-absolute top-0 start-0 m-2">
                                    <?= esc($galleryTypes[$image['gallery_type']] ?? ucfirst((string) $image['gallery_type'])) ?>
                                </span>
                                <div class="card-img-actions-overlay card-img-top d-flex align-items-start justify-content-end p-2">
                                    <button type="button" class="btn btn-danger btn-icon btn-sm gallery-delete" data-image-id="<?= esc($image['id']) ?>">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadInput = document.getElementById('gallery-upload');
        const galleryList = document.getElementById('gallery-list');
        const galleryFeedback = document.getElementById('gallery-feedback');
        const galleryTypeSelect = document.getElementById('gallery_type');
        const uploadUrl = '<?= base_url('gallery/images/upload') ?>';
        const deleteUrlBase = '<?= base_url('gallery/images/delete') ?>';
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
                '<span class="badge bg-dark bg-opacity-75 position-absolute top-0 start-0 m-2">' + image.gallery_type_label + '</span>' +
                '<div class="card-img-actions-overlay card-img-top d-flex align-items-start justify-content-end p-2">' +
                '<button type="button" class="btn btn-danger btn-icon btn-sm gallery-delete" data-image-id="' + image.id + '">' +
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
            if (galleryTypeSelect.value === 'all') {
                showGalleryMessage('Please select a gallery type before uploading images.', 'danger');
                return;
            }

            const formData = new FormData();

            formData.append('gallery_type', galleryTypeSelect.value);
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
                        galleryList.appendChild(createImageCard(body.data));
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
            document.querySelectorAll('.gallery-delete').forEach(button => {
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

<?= $this->endSection() ?>
