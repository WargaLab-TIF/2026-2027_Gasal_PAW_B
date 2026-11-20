
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

// Mencegah akun yang sedang digunakan dihapus
if ($id == $_SESSION['id_user']) {
    die('Akun yang sedang digunakan tidak bisa dihapus. <a href="data.php">Kembali</a>');
}

// Menghapus user
$query = mysqli_prepare($conn, "DELETE FROM user WHERE id_user = ?");
mysqli_stmt_bind_param($query, "i", $id);

if (mysqli_stmt_execute($query)) {
    header("Location: data.php");
    exit;
} else {
    die("User gagal dihapus. Pastikan user tidak sedang digunakan.");
}
?>
