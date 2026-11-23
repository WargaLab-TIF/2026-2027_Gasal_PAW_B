<?php
include 'koneksi.php';

$id = $_GET['id'];

$query = "DELETE FROM supplier WHERE id='$id'";
mysqli_query($conn, $query);

header("Location: soal1.php");
?>