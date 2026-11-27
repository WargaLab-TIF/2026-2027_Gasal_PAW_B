<?php
$hanya_owner = true;
require "fungsi.php";

try {
    hapus_buku($_GET['id_buku'] ?? 0);
} catch (mysqli_sql_exception $e) {
    echo "<script>alert('Buku sudah dipakai di transaksi, tidak bisa dihapus'); window.location='barang.php'</script>";
    exit();
}

header("Location: barang.php");
exit();
