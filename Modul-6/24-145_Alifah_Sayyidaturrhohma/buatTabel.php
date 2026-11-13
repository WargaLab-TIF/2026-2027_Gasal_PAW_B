<?php
include 'koneksi.php';

// Membuat tabel supplier
$supplier = "CREATE TABLE IF NOT EXISTS supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(12) NOT NULL,
    alamat TEXT NOT NULL
)";

if (mysqli_query($conn, $supplier)) {
    echo "Tabel supplier berhasil dibuat!";
} else {
    echo "Gagal membuat tabel supplier: " . mysqli_error($conn);
}

// Membuat tabel barang
$barang = "CREATE TABLE IF NOT EXISTS barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(10) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL,
    supplier_id INT NOT NULL,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id)
)";

if (mysqli_query($conn, $barang)) {
    echo "<br>Tabel barang berhasil dibuat!";
} else {
    echo "<br>Gagal membuat tabel barang: " . mysqli_error($conn);
}

// Membuat tabel pelanggan
$pelanggan = "CREATE TABLE IF NOT EXISTS pelanggan (
    id VARCHAR(20) PRIMARY KEY,
    nama VARCHAR(100),
    jenis_kelamin ENUM('L', 'P'),
    telp VARCHAR(12),
    alamat TEXT
)";

if (mysqli_query($conn, $pelanggan)) {
    echo "<br>Tabel pelanggan berhasil dibuat!";
} else {
    echo "<br>Gagal membuat tabel pelanggan: " . mysqli_error($conn);
}

// Membuat tabel user
$user = "CREATE TABLE IF NOT EXISTS user (
    id_user TINYINT PRIMARY KEY,
    username VARCHAR(30),
    password VARCHAR(35),
    nama VARCHAR(50),
    alamat VARCHAR(150),
    hp VARCHAR(20),
    level TINYINT(1)
)";

if (mysqli_query($conn, $user)) {
    echo "<br>Tabel user berhasil dibuat!";
} else {
    echo "<br>Gagal membuat tabel user: " . mysqli_error($conn);
}

// Membuat tabel transaksi
$transaksi = "CREATE TABLE IF NOT EXISTS transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE,
    keterangan TEXT,
    total INT,
    pelanggan_id VARCHAR(20),
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
)";

if (mysqli_query($conn, $transaksi)) {
    echo "<br>Tabel transaksi berhasil dibuat!";
} else {
    echo "<br>Gagal membuat tabel transaksi: " . mysqli_error($conn);
}

// Membuat tabel transaksi_detail
$transaksi_detail = "CREATE TABLE IF NOT EXISTS transaksi_detail (
    transaksi_id INT NOT NULL,
    barang_id INT NOT NULL,
    harga INT NOT NULL,
    qty INT NOT NULL,
    PRIMARY KEY (transaksi_id, barang_id),
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id),
    FOREIGN KEY (barang_id) REFERENCES barang(id)
)";

if (mysqli_query($conn, $transaksi_detail)) {
    echo "<br>Tabel transaksi_detail berhasil dibuat!";
} else {
    echo "<br>Gagal membuat tabel transaksi_detail: " . mysqli_error($conn);
}

// Membuat tabel pembayaran
$pembayaran = "CREATE TABLE IF NOT EXISTS pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar DATETIME,
    total INT,
    metode ENUM('TUNAI', 'TRANSFER', 'EDC'),
    transaksi_id INT,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
)";

if (mysqli_query($conn, $pembayaran)) {
    echo "<br>Tabel pembayaran berhasil dibuat!";
} else {
    echo "<br>Gagal membuat tabel pembayaran: " . mysqli_error($conn);
}

?>
