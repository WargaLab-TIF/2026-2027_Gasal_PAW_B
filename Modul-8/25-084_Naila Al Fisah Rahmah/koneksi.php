<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "db_Penjualan";

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi) {
    die("GAGAL KONEKSI KE DATABASE");
}
?>