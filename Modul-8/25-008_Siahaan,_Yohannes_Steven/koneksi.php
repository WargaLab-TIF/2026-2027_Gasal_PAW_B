<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "dbpenjualan";

$connect = mysqli_connect($host, $username, $password, $dbname);

if (!$connect) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
