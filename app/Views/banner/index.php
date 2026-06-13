<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">Banners</a>
                <span class="breadcrumb-item active">List Banners</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        <div class="collapse d-lg-block ms-lg-auto" id="breadcrumb_elements">
            <div class="d-lg-flex mb-2 mb-lg-0">
                <a href="<?= base_url('banners/create') ?>" class="btn btn-primary">
                    <i class="icon-plus2 mr-2"></i> Add New Banner
                </a>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table datatable-basic table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Page</th>
                            <th>Image</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($banners)): ?>
                            <tr>
                                <td colspan="6" class="text-center">No banners found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($banners as $banner): ?>
                                <tr>
                                    <td><?= esc($banner['title']) ?></td>
                                    <td><?= esc($banner['page'] ?? 'home') ?></td>
                                    <td>
                                        <?php if (! empty($banner['image'])): ?>
                                            <img src="<?= base_url($banner['image']) ?>" alt="" style="height:40px; object-fit:cover;">
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc((string) ($banner['sort_order'] ?? 0)) ?></td>
                                    <td>
                                        <?php if ($banner['status'] == 1): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('banners/edit/' . $banner['id']) ?>" class="list-icons-item text-primary-600" data-popup="tooltip" title="Edit" data-original-title="Edit">
                                            <i class="icon-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('banners/delete/' . $banner['id']) ?>" class="list-icons-item text-danger bootbox_custom" onclick1="return confirm('Are you sure?')" data-original-title="Delete">
                                            <i class="icon-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
