<?php
include 'koneksi.php';

$id = (int) $_GET['id'];

$stmt = mysqli_prepare($conn, "DELETE FROM supplier WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: index.php");
exit;
