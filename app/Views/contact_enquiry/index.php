<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<?php

$statusTab = $statusTab ?? 'new';
$enquiryType = $enquiryType ?? 'contact'; // use existing or fallback

$statusClasses = [
    'new'     => 'bg-danger',
    'read'    => 'bg-info',
    'replied' => 'bg-success',
    'closed'  => 'bg-secondary',
];

$statusLabels = [
    'new'     => 'New',
    'read'    => 'Read',
    'replied' => 'Replied',
    'closed'  => 'Closed',
];

$isArchivePage = $statusTab === 'archive';
$isPackageEnquiry = $enquiryType === 'package';
$emptyColspan = $isPackageEnquiry ? ($isArchivePage ? 11 : 12) : ($isArchivePage ? 8 : 9);
?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="#" class="breadcrumb-item">Enquiries</a>
                <span class="breadcrumb-item active"><?= esc($pageTitle) ?></span>
            </div>

            <a href="#breadcrumb_elements" class="btn btn-light align-self-center collapsed d-lg-none border-transparent rounded-pill p-0 ms-auto" data-bs-toggle="collapse">
                <i class="ph-caret-down collapsible-indicator ph-sm m-1"></i>
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
            <form action="<?= base_url('contact-enquiries/bulk-archive') ?>" method="POST">
                <?= csrf_field() ?>

                <?php if (! $isArchivePage): ?>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="icon-archive"></i> Archive Selected
                        </button>
                    </div>
                <?php endif; ?>

            <div class="table-responsive">
                <table class="table datatable-enquiries table-bordered table-striped table-hover" data-ajax-url="<?= base_url('contact-enquiries/data/' . $enquiryType . '/' . $statusTab) ?>">
                    <thead>
                        <tr>
                            <?php if (! $isArchivePage): ?>
                                <th>
                                    <input type="checkbox" id="select_all_enquiries">
                                </th>
                            <?php endif; ?>
                            <th>ID</th>
                            
                            <th>Name</th>
                            <?php if ($isPackageEnquiry): ?>
                                <th>Package</th>
                            <?php else: ?>
                                <th>Subject</th>
                            <?php endif; ?>
                            <th class="table-status-nowrap">Status</th>
                            <th class="table-date-nowrap">Created At</th>
                            <th class="table-actions-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('pageScripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const enquiryTable = $('.datatable-enquiries');
        const selectAll = document.getElementById('select_all_enquiries');

        if (enquiryTable.length && $().DataTable) {
            const columns = [
                <?php if (! $isArchivePage): ?>
                    { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
                <?php endif; ?>
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'subject', name: '<?= $isPackageEnquiry ? 'package_title' : 'subject' ?>' },
                { data: 'status', name: 'status', className: 'table-status-nowrap' },
                { data: 'created_at', name: 'created_at', className: 'table-date-nowrap' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'table-actions-nowrap' }
            ];

            enquiryTable.DataTable({
                processing: true,
                serverSide: true,
                ajax: enquiryTable.data('ajax-url'),
                columns: columns,
                order: [[<?= $isArchivePage ? 4 : 5 ?>, 'desc']],
                autoWidth: false,
                dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                language: {
                    search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                    searchPlaceholder: 'Type to filter...',
                    lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                    processing: 'Loading enquiries...',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
                },
                drawCallback: function() {
                    if (selectAll) {
                        selectAll.checked = false;
                    }
                }
            });
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                document.querySelectorAll('.enquiry-checkbox').forEach(function(checkbox) {
                    checkbox.checked = selectAll.checked;
                });
            });
        }

        $(document).on('click', '.datatable-enquiries .bootbox_custom', function(e) {
            e.preventDefault();

            const url = this.getAttribute('href');

            bootbox.confirm({
                title: 'Delete Record',
                message: 'Are you sure you want to delete this record?',
                buttons: {
                    confirm: {
                        label: 'Yes, Delete',
                        className: 'btn-danger'
                    },
                    cancel: {
                        label: 'Cancel',
                        className: 'btn-link'
                    }
                },
                callback: function(result) {
                    if (result) {
                        window.location.href = url;
                    }
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>
