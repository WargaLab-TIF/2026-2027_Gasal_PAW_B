<?php
require_once 'auth.php';
require_login();
include "koneksi.php";

if (isset($_POST['transaksi_id']) && isset($_POST['barang_id'])) {
    $transaksi_id = (int) $_POST['transaksi_id'];
    $barang_id = (int) $_POST['barang_id'];

    mysqli_query($conn, "DELETE FROM transaksi_detail WHERE transaksi_id=$transaksi_id AND barang_id=$barang_id");
    $query_total = mysqli_query($conn, "SELECT COALESCE(SUM(harga * qty), 0) AS total FROM transaksi_detail WHERE transaksi_id=$transaksi_id");
    $data_total = mysqli_fetch_assoc($query_total);
    $total = $data_total['total'];
    mysqli_query($conn, "UPDATE transaksi SET total=$total WHERE id=$transaksi_id");
    header("Location: transaksi.php?id=$transaksi_id");
    exit();
}
header("Location: transaksi.php");
exit();
?>
