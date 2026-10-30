<?php

$servername = "localhost";
$username = "root";
$password = ""; // Isi password MySQL jika ada

// Koneksi ke MySQL tanpa memilih database
$conn = mysqli_connect(
    $servername,
    $username,
    $password
);

if (!$conn) {
    die("Koneksi MySQL gagal: " . mysqli_connect_error());
}

echo "Koneksi MySQL berhasil!<br>";

// Membuat database
$sql = "CREATE DATABASE IF NOT EXISTS db_supplier";

if (mysqli_query($conn, $sql)) {
    echo "Database berhasil dibuat!<br>";
} else {
    die("Gagal membuat database: " . mysqli_error($conn));
}

// Memilih database
mysqli_select_db($conn, "db_supplier");

// Membuat tabel
$sql = "CREATE TABLE IF NOT EXISTS supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(20) NOT NULL,
    alamat VARCHAR(150) NOT NULL
)";

if (mysqli_query($conn, $sql)) {
    echo "Tabel supplier berhasil dibuat!<br>";
} else {
    die("Gagal membuat tabel: " . mysqli_error($conn));
}

// Memasukkan data awal jika tabel masih kosong
$cek = mysqli_query($conn, "SELECT COUNT(*) AS total FROM supplier");
$jumlah = mysqli_fetch_assoc($cek)['total'];

if ($jumlah == 0) {

    $sql = "INSERT INTO supplier (nama, telp, alamat) VALUES
    ('PT. Maju Bersama', '081234567890', 'Surabaya'),
    ('PT. Sinar Sejati', '0815115563', 'Bangkalan'),
    ('PT. Segar Segar', '0845454663', 'Surabaya')";

    if (mysqli_query($conn, $sql)) {
        echo "Data supplier berhasil ditambahkan!<br>";
    }
}

echo "<h3>DATABASE SIAP DIGUNAKAN!</h3>";

mysqli_close($conn);

?>