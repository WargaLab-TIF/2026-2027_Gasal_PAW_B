<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$transaksi_id = (int)($_POST['transaksi_id'] ?? 0);
$barang_id = (int)($_POST['barang_id'] ?? 0);
$qty = (int)($_POST['qty'] ?? 0);

if ($transaksi_id <= 0 || $barang_id <= 0 || $qty <= 0) {
    die("Input tidak valid. <a href='detail_transaksi.php?id=$transaksi_id'>Kembali</a>");
}

$stmt = mysqli_prepare($koneksi, "SELECT harga,stok FROM barang WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $barang_id);
mysqli_stmt_execute($stmt);

$barang = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$barang) {
    die("Barang tidak ditemukan.");
}

if ($qty > (int)$barang['stok']) {
    die("Qty melebihi stok barang.");
}

$stmt = mysqli_prepare($koneksi, "SELECT id FROM transaksi WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $transaksi_id);
mysqli_stmt_execute($stmt);

if (!mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
    die("Transaksi tidak ditemukan.");
}

$stmt = mysqli_prepare($koneksi, "SELECT barang_id FROM transaksi_detail WHERE transaksi_id=? AND barang_id=?");
mysqli_stmt_bind_param($stmt, "ii", $transaksi_id, $barang_id);
mysqli_stmt_execute($stmt);

if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
    die("Barang tersebut sudah ada pada transaksi ini. <a href='detail_transaksi.php?id=$transaksi_id'>Kembali</a>");
}

mysqli_begin_transaction($koneksi);

try {
    $harga = (int)$barang['harga'];

    $stmt = mysqli_prepare($koneksi, "INSERT INTO transaksi_detail (transaksi_id,barang_id,harga,qty) VALUES (?,?,?,?)");
    mysqli_stmt_bind_param($stmt, "iiii", $transaksi_id, $barang_id, $harga, $qty);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($koneksi));
    }

    $stmt = mysqli_prepare($koneksi, "UPDATE transaksi SET total=(SELECT COALESCE(SUM(harga*qty),0) FROM transaksi_detail WHERE transaksi_id=?) WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ii", $transaksi_id, $transaksi_id);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception(mysqli_error($koneksi));
    }

    mysqli_commit($koneksi);

    header("Location: detail_transaksi.php?id=" . $transaksi_id);
    exit;

} catch (Exception $e) {
    mysqli_rollback($koneksi);

    die("Gagal menyimpan detail: " . htmlspecialchars($e->getMessage()));
}
?>