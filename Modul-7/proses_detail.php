<?php
include 'koneksi.php';

$transaksi_id = $_POST['transaksi_id'];
$barang_id = $_POST['barang_id'];
$qty = $_POST['qty'];

// Mengambil harga barang
$query_barang = mysqli_query($koneksi, "
    SELECT harga FROM barang
    WHERE id = '$barang_id'
");

$barang = mysqli_fetch_assoc($query_barang);
$harga = $barang['harga'];

// Menyimpan detail transaksi
mysqli_query($koneksi, "
    INSERT INTO transaksi_detail
    (transaksi_id, barang_id, harga, qty)
    VALUES
    ('$transaksi_id', '$barang_id', '$harga', '$qty')
");

// Menghitung ulang total transaksi
mysqli_query($koneksi, "
    UPDATE transaksi
    SET total = (
        SELECT COALESCE(SUM(harga * qty), 0)
        FROM transaksi_detail
        WHERE transaksi_id = '$transaksi_id'
    )
    WHERE id = '$transaksi_id'
");

// Kembali ke halaman detail
header("Location: detail.php?id=$transaksi_id");
exit;
?>