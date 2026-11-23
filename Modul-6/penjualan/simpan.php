<?php
include 'koneksi.php';

$id = $_POST['transaksi_id'];
$barang = $_POST['barang'];
$qty = $_POST['qty'];

$data = mysqli_query($conn, "SELECT harga FROM barang WHERE id='$barang'");
$b = mysqli_fetch_assoc($data);

$harga = $b['harga'];

$query = "INSERT INTO transaksi_detail
(transaksi_id, barang_id, harga, qty)
VALUES ('$id', '$barang', '$harga', '$qty')";

mysqli_query($conn, $query);

header("Location: detail.php?id=$id");
?>
