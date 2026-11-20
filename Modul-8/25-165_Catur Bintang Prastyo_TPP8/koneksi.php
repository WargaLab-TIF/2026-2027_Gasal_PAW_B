<?php
$connect = mysqli_connect("localhost", "root", "", "dbpenjualan");
if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
