<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbsuply";

$koneksi = mysqli_connect($servername, $username, $password, $dbname);

if (!$koneksi) {
	die("koneksi gagal: " . mysqli_connect_error());
}
?>