<?php
$conn = mysqli_connect("localhost", "root", "", "db_penjualan");
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

if (!defined('BASE_URL')) {
    $folder = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $rootFolder = str_replace('\\', '/', substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT'])));
    define('BASE_URL', rtrim($rootFolder, '/'));
}
?>
