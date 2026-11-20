<?php
require_once 'auth.php';
require_owner();
include "koneksi.php";
$id = (int) $_POST['id'];
$cek = mysqli_query($conn, "SELECT * FROM transaksi_detail WHERE barang_id=$id");
if (mysqli_num_rows($cek) > 0) {
    header("Location: barang.php?error=1&status=Barang masih digunakan dalam transaksi");
} else {
    mysqli_query($conn, "DELETE FROM barang WHERE id=$id");
    header("Location: barang.php?status=Barang berhasil dihapus");
}
exit();
?>
