<?php
include 'koneksi.php';
$id = (int)$_GET['id'];

$cek = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT COUNT(*) AS jml FROM transaksi_detail WHERE barang_id = $id"));

if ($cek['jml'] > 0) {
    echo "<script>
            alert('Barang tidak dapat dihapus karena masih digunakan pada transaksi!');
            window.location = 'barang.php';
          </script>";
    exit;
}

mysqli_query($koneksi, "DELETE FROM barang WHERE id = $id");
header("Location: barang.php");
exit;
?>