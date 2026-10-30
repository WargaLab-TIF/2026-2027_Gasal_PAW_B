<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_supplier";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query = "CREATE TABLE IF NOT EXISTS supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(20) NOT NULL,
    alamat VARCHAR(150) NOT NULL
)";

if (mysqli_query($conn, $query)) {
    echo "Tabel supplier berhasil dibuat.";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>