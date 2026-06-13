<?= $this->include('layouts/header') ?>

<body>
    <?= $this->include('layouts/navbar') ?>

    <div class="page-content">
        <?= $this->include('layouts/sidebar') ?>

        <div class="content-wrapper">
            <div class="content-inner">
                <?= $this->renderSection('content') ?>
                <?= $this->include('layouts/footer') ?>
            </div>
        </div>
    </div>

    <?= $this->include('layouts/scripts') ?>


    