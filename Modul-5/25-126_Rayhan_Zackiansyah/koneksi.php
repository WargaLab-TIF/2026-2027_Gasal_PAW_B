<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbmodul5";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS dbmodul5";
mysqli_query($conn, $sql);

mysqli_select_db($conn, $dbname);

$sql = "CREATE TABLE IF NOT EXISTS supplier (
  id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(50) NOT NULL,
  telp VARCHAR(20) NOT NULL,
  alamat VARCHAR(100) NOT NULL
)";

mysqli_query($conn, $sql);

$sql = "SELECT COUNT(*) AS jumlah FROM supplier";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row["jumlah"] == 0) {
  $sql = "INSERT INTO supplier (nama, telp, alamat) VALUES
  ('PT. Maju Bersama', '08123456', 'Surabaya'),
  ('PT. Senang Sekali', '081515563', 'Bangkalan'),
  ('PT. Segar Segar', '0845454663', 'Surabaya')";

  mysqli_query($conn, $sql);
}
?>