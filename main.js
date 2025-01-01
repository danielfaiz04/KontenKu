$(document).ready(function() {
    // Fungsi untuk menampilkan notifikasi
    function showNotification(message, type = 'success') {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
        $('#notification-area').html(alertHtml);
        
        // Hilangkan notifikasi setelah 3 detik
        setTimeout(() => {
            $('.alert').alert('close');
        }, 3000);
    }

    // Konfirmasi hapus ide
    $('.delete-idea').click(function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        
        if (confirm('Apakah Anda yakin ingin menghapus ide ini?')) {
            $.ajax({
                url: 'ajax/delete_idea.php',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        row.fadeOut(400, function() {
                            $(this).remove();
                            showNotification('Ide berhasil dihapus');
                        });
                    } else {
                        showNotification('Gagal menghapus ide', 'danger');
                    }
                },
                error: function() {
                    showNotification('Terjadi kesalahan sistem', 'danger');
                }
            });
        }
    });

    // Konfirmasi hapus produk
    $('.delete-product').click(function() {
        const id = $(this).data('id');
        const row = $(this).closest('tr');
        
        if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
            $.ajax({
                url: 'ajax/delete_product.php',
                type: 'POST',
                data: {id: id},
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        row.fadeOut(400, function() {
                            $(this).remove();
                            showNotification('Produk berhasil dihapus');
                        });
                    } else {
                        showNotification('Gagal menghapus produk', 'danger');
                    }
                },
                error: function() {
                    showNotification('Terjadi kesalahan sistem', 'danger');
                }
            });
        }
    });

    // Filter status
    $('.status-filter').change(function() {
        const status = $(this).val();
        window.location.href = 'index.php?page=ideas&status=' + status;
    });
}); 