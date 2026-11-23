<?php
$koneksi = mysqli_connect("localhost", "root", "", "penjualan"
);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
