<?php
include "koneksi.php";

if (!isset($_GET['id'])) {
    die("ID barang tidak ditemukan.");
}

$id = (int) $_GET['id'];

// Periksa apakah barang sudah digunakan
$stmt = mysqli_prepare($koneksi, "
    SELECT COUNT(*) AS jumlah
    FROM transaksi_detail
    WHERE barang_id = ?
");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$hasil = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ($hasil['jumlah'] > 0) {
    echo "<script>
        alert('Barang tidak dapat dihapus karena masih digunakan pada transaksi!');
        window.location='data_barang.php';
    </script>";
    exit;
}

// Hapus barang jika belum digunakan
$stmt = mysqli_prepare($koneksi, "
    DELETE FROM barang WHERE id = ?
");

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>
        alert('Data barang berhasil dihapus!');
        window.location='data_barang.php';
    </script>";
} else {
    echo "<script>
        alert('Data barang gagal dihapus!');
        window.location='data_barang.php';
    </script>";
}
?>
