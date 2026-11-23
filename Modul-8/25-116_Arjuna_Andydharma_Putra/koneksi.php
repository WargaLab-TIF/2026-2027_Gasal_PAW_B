<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "penjualan";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// tentukan path login sesuai lokasi file
function path_login() {
    if (strpos($_SERVER['PHP_SELF'], '/barang/') !== false ||
        strpos($_SERVER['PHP_SELF'], '/supplier/') !== false ||
        strpos($_SERVER['PHP_SELF'], '/pelanggan/') !== false ||
        strpos($_SERVER['PHP_SELF'], '/user/') !== false ||
        strpos($_SERVER['PHP_SELF'], '/transaksi/') !== false ||
        strpos($_SERVER['PHP_SELF'], '/laporan/') !== false) {
        return '../login.php';
    }
    return 'login.php';
}

// cek apakah user sudah login
function cek_login() {
    if (!isset($_SESSION['id_user'])) {
        header("Location: " . path_login());
        exit;
    }
}
?>
