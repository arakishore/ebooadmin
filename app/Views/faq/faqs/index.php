<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">FAQs</a>
                <span class="breadcrumb-item active">List FAQs</span>
            </div>
        </div>

        <div class="ms-lg-auto">
            <a href="<?= base_url('faqs/create') ?>" class="btn btn-primary">
                <i class="icon-plus2 me-2"></i> Add New FAQ
            </a>
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
                            <th>Question</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($faqs)): ?>
                            <tr>
                                <td colspan="4" class="text-center">No FAQs found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($faqs as $faq): ?>
                                <tr>
                                    <td><?= esc((string) $faq['question']) ?></td>
                                    <td><?= esc((string) ($categoryMap[$faq['category_id']] ?? 'Uncategorized')) ?></td>
                                    <td>
                                        <?php if ($faq['status'] == 1): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('faqs/edit/' . $faq['id']) ?>" class="text-primary me-2" title="Edit">
                                            <i class="icon-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('faqs/delete/' . $faq['id']) ?>" class="text-danger bootbox_custom" onclick1="return confirm('Are you sure?')" title="Delete">
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
