<?php
$products = (new Product($database))->getAll();
?>

<div class="content-wrapper">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Daftar Produk</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="index.php?page=product-create" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product->name); ?></td>
                            <td><?php echo htmlspecialchars($product->description ?? ''); ?></td>
                            <td><?php echo number_format($product->price ?? 0, 0, ',', '.'); ?></td>
                            <td>
                                <button class="btn btn-sm btn-danger delete-product" 
                                        data-id="<?php echo $product->_id; ?>">Hapus</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div> 