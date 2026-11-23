
<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: barang.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);

if ($id <= 0) {
    header('Location: barang.php');
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) AS jumlah FROM transaksi_detail WHERE barang_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$cek = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if ((int)$cek['jumlah'] > 0) {
    header('Location: barang.php?pesan=terpakai');
    exit;
}

$stmt = mysqli_prepare($koneksi, "DELETE FROM barang WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
    header('Location: barang.php?pesan=hapus');
} else {
    header('Location: barang.php?pesan=gagal');
}

exit;
?>