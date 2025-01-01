<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'price' => (float) $_POST['price']
    ];
    
    $product = new Product($database);
    if ($product->create($data)) {
        header('Location: index.php?page=products&message=created');
        exit;
    }
}
?>

<div class="card">
    <div class="card-header">
        <h2>Tambah Produk Baru</h2>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" name="price" class="form-control" required>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="index.php?page=products" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div> 