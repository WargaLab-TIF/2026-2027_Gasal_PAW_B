<?php 
	include 'koneksi.php';

	$id = $_GET['id'];
	$query = "DELETE FROM supplier WHERE id = $id";

	if (mysqli_query($conn, $query)) {
		header("Location: index.php");
	} else {
		echo "Gagal Menghapus data" . mysqli_error($conn);
	}
?>