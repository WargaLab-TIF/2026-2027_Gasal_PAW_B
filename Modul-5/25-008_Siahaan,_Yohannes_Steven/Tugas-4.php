<?php
require "koneksidb.php";

$nomor = $_GET['nomor'];
$query = "DELETE FROM perusahaan WHERE nomor=$nomor";

if (mysqli_query($conn, $query)) {
	echo "Data berhasil dihapus";
} else {
	echo "Error: " . mysqli_error($conn);
}