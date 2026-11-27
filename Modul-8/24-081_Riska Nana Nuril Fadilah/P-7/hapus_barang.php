<?php
require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID barang tidak ditemukan!");
}

$query_cek = "SELECT * FROM transaksi_detail
              WHERE barang_id = '$id'";

$result_cek = mysqli_query($conn, $query_cek);

if (!$result_cek) {
    die("Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($result_cek) > 0) {
    header("Location: barang.php?pesan=gagal");
    exit;
}

$query = "DELETE FROM barang WHERE id = '$id'";

if (mysqli_query($conn, $query)) {
    header("Location: barang.php?pesan=berhasil");
    exit;
} else {
    echo "Error: " . mysqli_error($conn);
}
?>