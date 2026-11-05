<?php
require "koneksi.php";
$query = "CREATE DATABASE dbperusahaan";

if (mysqli_query($conn, $query)) {
	echo "Database berhasil dibuat";
} else {
	echo "Error: " . mysqli_error($conn);
}
?>