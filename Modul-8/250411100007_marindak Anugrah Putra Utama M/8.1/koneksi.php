<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "perpustakaan";

$connect = mysqli_connect($host, $username, $password, $dbname);

if (!$connect) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($connect, "utf8mb4");
?>
