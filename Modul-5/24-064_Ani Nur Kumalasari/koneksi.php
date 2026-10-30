<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "modul5";
$port = 33061;

$koneksi = mysqli_connect($hostname, $username, $password, $database, $port);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
