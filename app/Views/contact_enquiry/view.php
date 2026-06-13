<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<?php
$backUrl = $enquiry['enquiry_type'] === 'package' ? base_url('package-enquiries') : base_url('contact-messages');
$statusClasses = [
    'new'     => 'bg-danger',
    'read'    => 'bg-info',
    'replied' => 'bg-success',
    'closed'  => 'bg-secondary',
];
$statusLabels = [
    'read'    => 'Read',
    'replied' => 'Replied',
    'closed'  => 'Closed',
];
?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">CMS</a>
                <a href="<?= $backUrl ?>" class="breadcrumb-item"><?= esc($pageTitle) ?></a>
                <span class="breadcrumb-item active">View Enquiry</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        <div class="collapse d-lg-block ms-lg-auto" id="breadcrumb_elements">
            <div class="d-lg-flex mb-2 mb-lg-0">
                <a href="<?= $backUrl ?>" class="d-flex align-items-center text-body py-2">
                    <i class="icon-arrow-left7 me-2"></i>
                    Back to <?= esc($pageTitle) ?>
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

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title">Customer Details</h6>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Name</dt>
                        <dd class="col-sm-8"><?= esc($enquiry['name']) ?></dd>

                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8"><?= esc($enquiry['email']) ?></dd>

                        <dt class="col-sm-4">Phone</dt>
                        <dd class="col-sm-8"><?= esc($enquiry['phone'] ?? '-') ?></dd>

                        <dt class="col-sm-4">Subject</dt>
                        <dd class="col-sm-8"><?= esc($enquiry['subject'] ?? '-') ?></dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge <?= esc($statusClasses[$enquiry['status']] ?? 'bg-secondary') ?>">
                                <?= esc($statusLabels[$enquiry['status']] ?? ucfirst($enquiry['status'])) ?>
                            </span>
                        </dd>
                    </dl>
                </div>
            </div>

            <?php if ($enquiry['enquiry_type'] === 'package'): ?>
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">Package Details</h6>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-4">Package</dt>
                            <dd class="col-sm-8"><?= esc($enquiry['package_title'] ?? '-') ?></dd>

                            <dt class="col-sm-4">Travel Date</dt>
                            <dd class="col-sm-8"><?= esc($enquiry['travel_date'] ?? '-') ?></dd>

                            <dt class="col-sm-4">Adults</dt>
                            <dd class="col-sm-8"><?= esc((string) ($enquiry['adults'] ?? '-')) ?></dd>

                            <dt class="col-sm-4">Children</dt>
                            <dd class="col-sm-8"><?= esc((string) ($enquiry['children'] ?? '-')) ?></dd>
                        </dl>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title">Timestamps</h6>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Created</dt>
                        <dd class="col-sm-8"><?= esc($enquiry['created_at'] ?? '-') ?></dd>

                        <dt class="col-sm-4">Viewed</dt>
                        <dd class="col-sm-8"><?= esc($enquiry['viewed_at'] ?? '-') ?></dd>

                        <dt class="col-sm-4">Viewed By</dt>
                        <dd class="col-sm-8"><?= esc((string) ($enquiry['viewed_by'] ?? '-')) ?></dd>

                        <dt class="col-sm-4">Replied</dt>
                        <dd class="col-sm-8"><?= esc($enquiry['replied_at'] ?? '-') ?></dd>

                        <dt class="col-sm-4">Replied By</dt>
                        <dd class="col-sm-8"><?= esc((string) ($enquiry['replied_by'] ?? '-')) ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title">Enquiry Message</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0"><?= nl2br(esc($enquiry['message'])) ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title">Admin Response</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('contact-enquiries/update/' . $enquiry['id']) ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="form-group mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control form-control-select2" data-minimum-results-for-search="Infinity" id="status" name="status">
                                <?php foreach ($statusLabels as $value => $label): ?>
                                    <option value="<?= esc($value) ?>" <?= old('status', $enquiry['status']) === $value ? 'selected' : '' ?>>
                                        <?= esc($label) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="admin_note" class="form-label">Admin Note</label>
                            <textarea class="form-control" id="admin_note" name="admin_note" rows="5"><?= esc(old('admin_note', $enquiry['admin_note'] ?? '')) ?></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="reply_message" class="form-label">Reply Message</label>
                            <textarea class="form-control" id="reply_message" name="reply_message" rows="7"><?= esc(old('reply_message', $enquiry['reply_message'] ?? '')) ?></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success">
                                <i class="icon-check"></i> Save Enquiry
                            </button>
                            <a href="<?= $backUrl ?>" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
