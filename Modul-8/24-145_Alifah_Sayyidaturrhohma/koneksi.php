<?php
$conn = mysqli_connect("localhost", "root", "", "penjualan");

if (!$conn){
	die("koneksi database gagal: " . mysqli_connect_error());
}
?>
