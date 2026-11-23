<?php
include '../koneksi.php';
cek_login();
if ($_SESSION['level'] != 1) {
    echo "<script>alert('Akses ditolak!'); window.location='../index.php';</script>";
    exit;
}
$id = (int)$_GET['id'];
// jangan hapus diri sendiri
if ($id == $_SESSION['id_user']) {
    echo "<script>alert('Tidak bisa hapus akun sendiri!'); window.location='index.php';</script>";
    exit;
}
mysqli_query($conn, "DELETE FROM user WHERE id_user=$id");
header("Location: index.php");
exit;
?>
