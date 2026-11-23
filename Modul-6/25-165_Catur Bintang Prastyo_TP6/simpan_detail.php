<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: transaksi.php");
    exit;
}

$trx_id    = (int)($_POST['transaksi_id'] ?? 0);
$barang_id = (int)($_POST['barang_id'] ?? 0);
$qty       = (int)($_POST['qty'] ?? 0);

if ($trx_id === 0) {
    header("Location: transaksi.php");
    exit;
}
if ($barang_id === 0) {
    header("Location: detail.php?id=$trx_id&pesan=" . urlencode("Pilih barang terlebih dahulu."));
    exit;
}
if ($qty < 1) {
    header("Location: detail.php?id=$trx_id&pesan=" . urlencode("Qty minimal 1."));
    exit;
}

// Cek duplikat barang dalam transaksi yang sama
$cek = mysqli_query($koneksi,
    "SELECT 1 FROM transaksi_detail WHERE transaksi_id = $trx_id AND barang_id = $barang_id");
if (mysqli_num_rows($cek) > 0) {
    header("Location: detail.php?id=$trx_id&pesan=" . urlencode("Barang sudah ada dalam transaksi ini."));
    exit;
}

$b = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT harga FROM barang WHERE id = $barang_id"));
if (!$b) {
    header("Location: detail.php?id=$trx_id&pesan=" . urlencode("Barang tidak ditemukan."));
    exit;
}
$harga = (int)$b['harga'];

mysqli_query($koneksi,
    "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
     VALUES ($trx_id, $barang_id, $harga, $qty)");

mysqli_query($koneksi,
    "UPDATE transaksi
     SET total = (SELECT COALESCE(SUM(harga * qty), 0)
                  FROM transaksi_detail
                  WHERE transaksi_id = $trx_id)
     WHERE id = $trx_id");

header("Location: detail.php?id=$trx_id");
exit;
?>