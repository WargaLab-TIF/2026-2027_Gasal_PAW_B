<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbsuply";

$koneksi = mysqli_connect($servername, $username, $password, $dbname);

if (!$koneksi) {
	die("koneksi gagal: " . mysqli_connect_error());
}
echo "Koneksi sukses<br>";

$sql = "CREATE TABLE supplier (
		id INT(6) AUTO_INCREMENT PRIMARY KEY,
		nama VARCHAR (255) NOT NULL,
		telp VARCHAR (14) NOT NULL,
		alamat VARCHAR (255) 
		)";

if (mysqli_query($koneksi, $sql)){
	echo "Tabel berhasil dibuat";
} else {
	echo "Error, Tabel gagal dibuat".mysqli_error($koneksi);
}

mysqli_close($koneksi)
?>