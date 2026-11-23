<?php
$servername = "localhost";
$username = "root";
$password = "";

$koneksi = mysqli_connect($servername, $username, $password);

if (!$koneksi) {
	die("koneksi gagal: " . mysqli_connect_error());
}
echo "Koneksi sukses<br>";

$sql = "CREATE DATABASE dbsuply";

if (mysqli_query($koneksi, $sql)){
	echo "Database berhasil dibuat";
} else {
	echo "Error, Database gagal dibuat" . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>