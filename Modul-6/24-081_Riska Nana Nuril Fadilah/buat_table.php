<?php
require 'koneksi.php';

$query = "CREATE TABLE IF NOT EXISTS supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    telp VARCHAR(12),
    alamat TEXT
)";

if (mysqli_query($conn, $query)) {
    echo "Tabel supplier berhasil dibuat!<br>";
} else {
    echo "Error supplier: " . mysqli_error($conn) . "<br>";
}

$query = "CREATE TABLE IF NOT EXISTS barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(10),
    nama_barang VARCHAR(100),
    harga INT,
    stok INT,
    supplier_id INT,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id)
)";

if (mysqli_query($conn, $query)) {
    echo "Tabel barang berhasil dibuat!<br>";
} else {
    echo "Error barang: " . mysqli_error($conn) . "<br>";
}

$query = "CREATE TABLE IF NOT EXISTS pelanggan (
    id VARCHAR(20) PRIMARY KEY,
    nama VARCHAR(100),
    jenis_kelamin ENUM('L','P'),
    telp VARCHAR(12),
    alamat TEXT
)";

if (mysqli_query($conn, $query)) {
    echo "Tabel pelanggan berhasil dibuat!<br>";
} else {
    echo "Error pelanggan: " . mysqli_error($conn) . "<br>";
}

$query = "CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE,
    keterangan TEXT,
    total INT,
    pelanggan_id VARCHAR(20),
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
)";

if (mysqli_query($conn, $query)) {
    echo "Tabel transaksi berhasil dibuat!<br>";
} else {
    echo "Error transaksi: " . mysqli_error($conn) . "<br>";
}

$query = "CREATE TABLE IF NOT EXISTS transaksi_detail (
    transaksi_id INT,
    barang_id INT,
    harga INT,
    qty INT,
    PRIMARY KEY (transaksi_id, barang_id),
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id),
    FOREIGN KEY (barang_id) REFERENCES barang(id)
)";

if (mysqli_query($conn, $query)) {
    echo "Tabel transaksi_detail berhasil dibuat!<br>";
} else {
    echo "Error transaksi_detail: " . mysqli_error($conn) . "<br>";
}

$query = "CREATE TABLE IF NOT EXISTS pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar DATETIME,
    total INT,
    metode ENUM('TUNAI','TRANSFER','EDC'),
    transaksi_id INT,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
)";

if (mysqli_query($conn, $query)) {
    echo "Tabel pembayaran berhasil dibuat!<br>";
} else {
    echo "Error pembayaran: " . mysqli_error($conn) . "<br>";
}

$query = "CREATE TABLE IF NOT EXISTS user (
    id_user TINYINT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30),
    password VARCHAR(35),
    nama VARCHAR(50),
    alamat VARCHAR(150),
    hp VARCHAR(20),
    level TINYINT(1)
)";

if (mysqli_query($conn, $query)) {
    echo "Tabel user berhasil dibuat!<br>";
} else {
    echo "Error user: " . mysqli_error($conn) . "<br>";
}
?>