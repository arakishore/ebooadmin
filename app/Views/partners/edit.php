<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="<?= base_url('partners') ?>" class="breadcrumb-item">Partners</a>
                <span class="breadcrumb-item active">Edit Partner</span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
            </a>
        </div>

        <div class="collapse d-lg-block ms-lg-auto" id="breadcrumb_elements">
            <div class="d-lg-flex mb-2 mb-lg-0">
                <a href="<?= base_url('partners') ?>" class="d-flex align-items-center text-body py-2">
                    <i class="icon-arrow-left7 me-2"></i>
                    Back to Partners List
                </a>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h6 class="card-title">Edit Partner</h6>
        </div>
        <div class="card-body">
            <?= $this->include('partners/_form') ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
