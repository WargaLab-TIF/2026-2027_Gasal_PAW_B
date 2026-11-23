<?php
// Ganti username dan password sesuai MySQL Anda
$koneksi = mysqli_connect("localhost", "root", "", "penjualan");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
