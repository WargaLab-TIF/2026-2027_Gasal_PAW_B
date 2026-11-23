<?php
include '../koneksi.php';
cek_login();
if ($_SESSION['level'] != 1) {
    echo "<script>alert('Akses ditolak!'); window.location='../index.php';</script>";
    exit;
}
$id = mysqli_real_escape_string($conn, $_GET['id']);
mysqli_query($conn, "DELETE FROM pelanggan WHERE id='$id'");
header("Location: index.php");
exit;
?>
