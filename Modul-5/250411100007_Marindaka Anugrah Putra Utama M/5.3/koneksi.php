<?php
$conn = mysqli_connect("localhost", "root", "");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Setup otomatis: buat database & tabel kalau belum ada
mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS modul5");
mysqli_select_db($conn, "modul5");

$cek = mysqli_query($conn, "SHOW TABLES LIKE 'supplier'");
$baru = (mysqli_num_rows($cek) == 0);

mysqli_query($conn, "CREATE TABLE IF NOT EXISTS supplier (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(255) NOT NULL,
  telp VARCHAR(20) NOT NULL,
  alamat VARCHAR(255) NOT NULL
)");

if ($baru) {
  mysqli_query($conn, "INSERT INTO supplier (nama, telp, alamat) VALUES
    ('PT. Maju Bersama', '08123456', 'Surabaya'),
    ('PT. Senang Sekali', '081515563', 'Bangkalan'),
    ('PT. Segar Segar', '0845454663', 'Surabaya')");
}
?>
