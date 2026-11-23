<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "myDB";

$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS $dbname");
mysqli_select_db($conn, $dbname);

$sql = "CREATE TABLE IF NOT EXISTS supplier (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(20) NOT NULL,
    alamat VARCHAR(150) NOT NULL
)";
mysqli_query($conn, $sql);

$cek = mysqli_query($conn, "SELECT id FROM supplier");
if (mysqli_num_rows($cek) == 0) {
    $sql  = "INSERT INTO supplier (nama, telp, alamat) VALUES ('PT. Maju Bersama', '08123456', 'Surabaya');";
    $sql .= "INSERT INTO supplier (nama, telp, alamat) VALUES ('PT. Senang Sekali', '081515563', 'Bangkalan');";
    $sql .= "INSERT INTO supplier (nama, telp, alamat) VALUES ('PT. Segar Segar', '0845454663', 'Surabaya')";
    mysqli_multi_query($conn, $sql);
    while (mysqli_more_results($conn) && mysqli_next_result($conn)) { }
}
?>
