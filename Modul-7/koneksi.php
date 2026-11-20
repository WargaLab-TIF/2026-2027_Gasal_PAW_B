<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "penjualan";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
?>