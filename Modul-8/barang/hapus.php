<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['level'] != 1) {
    header("Location: ../index.php");
    exit;
}

require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: data.php");
    exit;
}

$query = mysqli_prepare($conn, "SELECT barang_id FROM transaksi_detail WHERE barang_id = ?");
mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);

if (mysqli_num_rows($result) > 0) {
    die('Barang masih digunakan pada transaksi. <a href="data.php">Kembali</a>');
}

$query = mysqli_prepare($conn, "DELETE FROM barang WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $id);

if (mysqli_stmt_execute($query)) {
    header("Location: data.php");
    exit;
} else {
    die('Barang gagal dihapus. <a href="data.php">Kembali</a>');
}
?>
