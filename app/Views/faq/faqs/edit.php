<?= $this->extend('layouts/master') ?>

<?= $this->section('content') ?>

<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="<?= base_url('dashboard') ?>" class="breadcrumb-item"><i class="ph-house"></i></a>
                <a href="<?= base_url('faqs') ?>" class="breadcrumb-item">FAQs</a>
                <span class="breadcrumb-item active">Edit FAQ</span>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('faqs/update/' . $faq['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select">
                        <option value="">Uncategorized</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= esc($category['id']) ?>" <?= old('category_id', $faq['category_id']) == $category['id'] ? 'selected' : '' ?> >
                                <?= esc($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Question</label>
                    <input type="text" name="question" value="<?= esc(old('question', $faq['question'])) ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Answer</label>
                    <textarea name="answer" rows="6" class="form-control" required><?= esc(old('answer', $faq['answer'])) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" value="<?= esc(old('sort_order', $faq['sort_order'])) ?>" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="1" <?= old('status', (string) $faq['status']) === '1' ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= old('status', (string) $faq['status']) === '0' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success">
                        <i class="icon-check"></i> Update FAQ
                    </button>
                    <a href="<?= base_url('faqs') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
