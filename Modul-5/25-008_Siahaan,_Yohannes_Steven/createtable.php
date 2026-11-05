<?php
require "koneksidb.php";
$query = "CREATE TABLE perusahaan (
	nomor INT AUTO_INCREMENT PRIMARY KEY,
	nama VARCHAR(255) NOT NULL,
	telp VARCHAR(255) NOT NULL,
	alamat VARCHAR(255) 
)";

if (mysqli_query($conn, $query)) {
	echo "Tabel mahasiswa berhasil dibuat";
} else {
	echo "Error: " . mysqli_error($conn);
}
?>