<?php
require_once "koneksi.php";

$id = (int) $_POST['id'];

// Mengecek barang di transaksi_detail
$stmt = mysqli_prepare($koneksi, "
    SELECT COUNT(*) AS jumlah
    FROM transaksi_detail
    WHERE barang_id = ?
");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if ($data['jumlah'] > 0) {
    echo "<script>
        alert('Barang tidak dapat dihapus karena masih digunakan pada transaksi!');
        window.location='barang.php';
    </script>";
    exit;
}

// Menghapus barang jika belum digunakan
$stmt = mysqli_prepare($koneksi, "
    DELETE FROM barang WHERE id = ?
");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

echo "<script>
    alert('Barang berhasil dihapus!');
    window.location='barang.php';
</script>";
exit;
?>