
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

$id = $_GET['id'] ?? '';

if ($id == '') {
    header("Location: data.php");
    exit;
}

// Mengecek apakah pelanggan sudah digunakan dalam transaksi
$cek = mysqli_prepare($conn, "SELECT id FROM transaksi WHERE pelanggan_id = ?");
mysqli_stmt_bind_param($cek, "s", $id);
mysqli_stmt_execute($cek);

$hasil = mysqli_stmt_get_result($cek);

if (mysqli_num_rows($hasil) > 0) {
    die('Pelanggan sudah digunakan pada transaksi. <a href="data.php">Kembali</a>');
}

// Menghapus pelanggan
$hapus = mysqli_prepare($conn, "DELETE FROM pelanggan WHERE id = ?");
mysqli_stmt_bind_param($hapus, "s", $id);

if (mysqli_stmt_execute($hapus)) {
    header("Location: data.php");
    exit;
} else {
    die("Data pelanggan gagal dihapus.");
}
?>
