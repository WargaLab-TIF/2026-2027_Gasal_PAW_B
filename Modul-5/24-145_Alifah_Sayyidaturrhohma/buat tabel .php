<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "modul5";

// Koneksi ke db yang telah di buat
$conn = mysqli_connect($hostname, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Membuat tabel supplier
$query = "CREATE TABLE IF NOT EXISTS supplier (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    telp VARCHAR(20) NOT NULL,
    alamat VARCHAR(100) NOT NULL
)";

if (mysqli_query($conn, $query)) {
    echo "Tabel supplier berhasil dibuat!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

