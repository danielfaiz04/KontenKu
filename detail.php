<?php
if (!isset($_GET['id'])) {
    header('Location: index.php?page=ideas');
    exit;
}

$ideaDetail = $idea->getById($_GET['id']);
if (!$ideaDetail) {
    header('Location: index.php?page=ideas');
    exit;
}
?>

<div class="content-wrapper">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="page-title mb-0">Detail Ide Konten</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="index.php?page=ideas" class="btn btn-outline-primary me-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <div class="btn-group">
                <a href="index.php?page=idea-edit&id=<?php echo $ideaDetail->_id; ?>" 
                   class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <button class="btn btn-danger delete-idea" data-id="<?php echo $ideaDetail->_id; ?>">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body p-4">
                    <!-- Judul Konten -->
                    <div class="detail-item mb-4">
                        <h5 class="detail-title">
                            <i class="fas fa-heading text-primary"></i> Judul Konten
                        </h5>
                        <div class="detail-content">
                            <?php echo htmlspecialchars($ideaDetail->title); ?>
                        </div>
                    </div>

                    <!-- Deskripsi Konten -->
                    <div class="detail-item mb-4">
                        <h5 class="detail-title">
                            <i class="fas fa-align-left text-primary"></i> Deskripsi Konten
                        </h5>
                        <div class="detail-content">
                            <?php echo nl2br(htmlspecialchars($ideaDetail->description)); ?>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Platform Target -->
                        <div class="col-md-6">
                            <div class="detail-item mb-4">
                                <h5 class="detail-title">
                                    <i class="fas fa-globe text-primary"></i> Platform Target
                                </h5>
                                <div class="detail-content">
                                    <?php 
                                    $platform = $ideaDetail->platform ?? '';
                                    echo !empty($platform) ? htmlspecialchars(ucfirst($platform)) : '-';
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Nama Produk -->
                        <div class="col-md-6">
                            <div class="detail-item mb-4">
                                <h5 class="detail-title">
                                    <i class="fas fa-box text-primary"></i> Nama Produk
                                </h5>
                                <div class="detail-content">
                                    <?php echo htmlspecialchars($ideaDetail->product ?? '-'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Kategori Konten -->
                        <div class="col-md-6">
                            <div class="detail-item mb-4">
                                <h5 class="detail-title">
                                    <i class="fas fa-folder text-primary"></i> Kategori Konten
                                </h5>
                                <div class="detail-content">
                                    <?php
                                    $categoryNames = [
                                        'edukasi' => 'Edukasi',
                                        'hiburan' => 'Hiburan',
                                        'tips' => 'Tips & Trik',
                                        'promosi' => 'Promosi Produk',
                                        'kolaborasi' => 'Kolaborasi'
                                    ];
                                    $category = $ideaDetail->category ?? '';
                                    echo isset($categoryNames[$category]) ? 
                                        htmlspecialchars($categoryNames[$category]) : '-';
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="detail-item mb-4">
                                <h5 class="detail-title">
                                    <i class="fas fa-info-circle text-primary"></i> Status
                                </h5>
                                <div class="detail-content">
                                    <?php
                                    $statusNames = [
                                        'draft' => 'Draft',
                                        'aktif' => 'Aktif',
                                        'selesai' => 'Selesai'
                                    ];
                                    $status = $ideaDetail->status ?? '';
                                    echo isset($statusNames[$status]) ? 
                                        htmlspecialchars($statusNames[$status]) : '-';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Posting -->
                    <div class="detail-item">
                        <h5 class="detail-title">
                            <i class="far fa-calendar-alt text-primary"></i> Tanggal Posting
                        </h5>
                        <div class="detail-content">
                            <?php 
                            if (!empty($ideaDetail->posting_date)) {
                                $bulan = [
                                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
                                    '04' => 'April', '05' => 'Mei', '06' => 'Juni',
                                    '07' => 'Juli', '08' => 'Agustus', '09' => 'September',
                                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                                ];
                                $tanggal = date('d', strtotime($ideaDetail->posting_date));
                                $bulan_angka = date('m', strtotime($ideaDetail->posting_date));
                                $tahun = date('Y', strtotime($ideaDetail->posting_date));
                                echo $tanggal . ' ' . $bulan[$bulan_angka] . ' ' . $tahun;
                            } else {
                                echo '-';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Pendukung -->
        <div class="col-md-4">
            <?php if (isset($ideaDetail->media)): ?>
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-photo-video text-primary"></i> Media Pendukung
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="media-preview mb-3">
                        <?php if (strpos($ideaDetail->media_type, 'image/') === 0): ?>
                            <img src="uploads/<?php echo $ideaDetail->media; ?>" 
                                 class="img-fluid rounded" 
                                 alt="Media konten">
                        <?php elseif (strpos($ideaDetail->media_type, 'video/') === 0): ?>
                            <video controls class="w-100 rounded">
                                <source src="uploads/<?php echo $ideaDetail->media; ?>" type="video/mp4">
                                Browser Anda tidak mendukung pemutaran video.
                            </video>
                        <?php else: ?>
                            <div class="text-center">
                                <i class="fas fa-file fa-3x text-primary"></i>
                                <p class="mt-2"><?php echo htmlspecialchars($ideaDetail->media); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="uploads/<?php echo $ideaDetail->media; ?>" 
                           class="btn btn-primary" 
                           download>
                            <i class="fas fa-download"></i> Download Media
                        </a>
                        <button type="button" class="btn btn-outline-primary" 
                                onclick="window.open('uploads/<?php echo $ideaDetail->media; ?>', '_blank')">
                            <i class="fas fa-external-link-alt"></i> Buka di Tab Baru
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.querySelector('.delete-idea').addEventListener('click', function() {
    if (confirm('Apakah Anda yakin ingin menghapus ide ini?')) {
        window.location = 'index.php?page=idea-delete&id=' + this.dataset.id;
    }
});
</script>

<style>
.content-header {
    padding: 2rem 0;
    margin: 0 15px;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #2c3e50;
}

.badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
    font-weight: 500;
}

.detail-item {
    position: relative;
    padding: 0 10px;
}

.detail-title {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.75rem;
}

.detail-content {
    color: #4a5568;
    line-height: 1.6;
    position: relative;
}

.detail-content p:last-child {
    margin-bottom: 0;
}

.card {
    border: none;
    border-radius: 0.75rem;
    margin: 0 15px;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,.05);
    padding: 1.25rem;
}

.media-preview {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.5rem;
    margin: 0 10px;
}

.btn-group .btn {
    border-radius: 0.5rem;
}

.btn-group .btn:not(:last-child) {
    margin-right: 0.25rem;
}

.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
}

.text-muted.small {
    font-size: 0.875rem;
    color: #6c757d !important;
}

/* Container styling */
.container {
    max-width: 1140px;
    padding-right: 30px;
    padding-left: 30px;
    margin-right: auto;
    margin-left: auto;
}

/* Responsive padding for different screen sizes */
@media (max-width: 768px) {
    .container {
        padding-right: 20px;
        padding-left: 20px;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .detail-item {
        padding: 0 5px;
    }
}
</style> 