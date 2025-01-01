<?php
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php?page=ideas');
    exit;
}

$ideaDetail = $idea->getById($id);
if (!$ideaDetail) {
    header('Location: index.php?page=ideas');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'platform' => $_POST['platform'],
        'product' => $_POST['product'] ?? '',
        'category' => $_POST['category'],
        'status' => $_POST['status'],
        'posting_date' => $_POST['posting_date'] ?? ''
    ];
    
    if ($idea->update($id, $data)) {
        header('Location: index.php?page=ideas&message=updated');
        exit;
    }
}
?>

<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h2>Edit Ide Konten</h2>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Judul Konten *</label>
                    <input type="text" name="title" class="form-control" 
                           value="<?php echo htmlspecialchars($ideaDetail->title); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Deskripsi Konten</label>
                    <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($ideaDetail->description); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Platform Target *</label>
                        <select name="platform" class="form-control" required>
                            <option value="">Pilih Platform</option>
                            <option value="TikTok" <?php echo $ideaDetail->platform === 'TikTok' ? 'selected' : ''; ?>>TikTok</option>
                            <option value="Instagram" <?php echo $ideaDetail->platform === 'Instagram' ? 'selected' : ''; ?>>Instagram</option>
                            <option value="YouTube" <?php echo $ideaDetail->platform === 'YouTube' ? 'selected' : ''; ?>>YouTube</option>
                            <option value="Facebook" <?php echo $ideaDetail->platform === 'Facebook' ? 'selected' : ''; ?>>Facebook</option>
                            <option value="Shopee" <?php echo $ideaDetail->platform === 'Shopee' ? 'selected' : ''; ?>>Shopee</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Produk</label>
                        <select name="product" class="form-control">
                            <option value="">Pilih nama produk yang dipromosikan</option>
                            <?php 
                            $products = (new Product($database))->getAll();
                            foreach ($products as $product): ?>
                                <option value="<?php echo htmlspecialchars($product->name); ?>"
                                        <?php echo $ideaDetail->product === $product->name ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($product->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Kategori Konten *</label>
                        <select name="category" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <option value="edukasi" <?php echo $ideaDetail->category === 'edukasi' ? 'selected' : ''; ?>>Edukasi</option>
                            <option value="hiburan" <?php echo $ideaDetail->category === 'hiburan' ? 'selected' : ''; ?>>Hiburan</option>
                            <option value="tips" <?php echo $ideaDetail->category === 'tips' ? 'selected' : ''; ?>>Tips & Trik</option>
                            <option value="promosi" <?php echo $ideaDetail->category === 'promosi' ? 'selected' : ''; ?>>Promosi Produk</option>
                            <option value="kolaborasi" <?php echo $ideaDetail->category === 'kolaborasi' ? 'selected' : ''; ?>>Kolaborasi</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-control" required>
                            <option value="draft" <?php echo $ideaDetail->status === 'draft' ? 'selected' : ''; ?>>Draft</option>
                            <option value="aktif" <?php echo $ideaDetail->status === 'aktif' ? 'selected' : ''; ?>>Aktif</option>
                            <option value="selesai" <?php echo $ideaDetail->status === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal Posting</label>
                    <input type="date" name="posting_date" class="form-control" 
                           value="<?php echo $ideaDetail->posting_date ?? ''; ?>">
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="index.php?page=ideas" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 