<?php
$servername = "localhost";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS modul5";

if (!mysqli_query($conn, $sql)) {
    die("Database gagal dibuat: " . mysqli_error($conn));
}

mysqli_select_db($conn, "modul5");

$sql = "CREATE TABLE IF NOT EXISTS supplier (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(30) NOT NULL,
    Telp VARCHAR(20) NOT NULL,
    Alamat VARCHAR(50) NOT NULL
)";

if (!mysqli_query($conn, $sql)) {
    die("Tabel gagal dibuat: " . mysqli_error($conn));
}

$cek = mysqli_query($conn, "SELECT COUNT(*) AS total FROM supplier");
$data = mysqli_fetch_assoc($cek);

if ($data['total'] == 0) {
    $sql = "INSERT INTO supplier (nama, Telp, Alamat) VALUES
    ('PT. Maju Bersama', '08123456', 'Surabaya'),
    ('PT. Senang Sekali', '081515563', 'Bangkalan'),
    ('PT. Segar Segar', '08454663', 'Surabaya')";

    mysqli_query($conn, $sql);
}
?>