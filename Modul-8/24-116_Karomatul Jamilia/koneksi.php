<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "db_penjualan";

mysqli_report(MYSQLI_REPORT_OFF);
$connect = mysqli_connect($host, $username, $password, $dbname);

if (!$connect) {
    echo "GAGAL KONEKSI KE DATABASE";
}
?>
