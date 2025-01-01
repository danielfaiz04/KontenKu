<?php
$totalIdeas = iterator_count($idea->getAll());
$activeIdeas = iterator_count($idea->getAll([
    'filter' => ['status' => 'aktif']
]));
$draftIdeas = iterator_count($idea->getAll([
    'filter' => ['status' => 'draft']
]));
$completedIdeas = iterator_count($idea->getAll([
    'filter' => ['status' => 'selesai']
]));
?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title mb-4">Dashboard</h1>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Ide</h5>
                    <h2 class="card-text mb-3"><?php echo $totalIdeas; ?></h2>
                    <a href="index.php?page=ideas" class="btn btn-primary">
                        Lihat Semua Ide
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Status Aktif</h5>
                    <h2 class="card-text mb-3"><?php echo $activeIdeas; ?></h2>
                    <a href="index.php?page=ideas&status=aktif" class="btn btn-success">
                        Lihat Ide Aktif
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Status Draft</h5>
                    <h2 class="card-text mb-3"><?php echo $draftIdeas; ?></h2>
                    <a href="index.php?page=ideas&status=draft" class="btn btn-secondary">
                        Lihat Draft
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Selesai</h5>
                    <h2 class="card-text mb-3"><?php echo $completedIdeas; ?></h2>
                    <a href="index.php?page=ideas&status=selesai" class="btn btn-info">
                        Lihat Selesai
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center p-5">
                    <h4 class="mb-4">Mulai Mengelola Ide Konten Anda</h4>
                    <p class="mb-4">
                        Tambahkan, kelola, dan pantau perkembangan ide konten Anda dengan mudah
                    </p>
                    <a href="index.php?page=idea-create" class="btn btn-lg btn-primary">
                        <i class="fas fa-plus"></i> Tambah Ide Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> 