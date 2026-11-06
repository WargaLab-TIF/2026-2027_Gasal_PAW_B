-- MEMBUAT DATABASE
CREATE DATABASE db_Penjualan;

-- Menggunakan database
USE db_Penjualan;

-- TABEL 1: USERS
-- Menyimpan akun pengguna sistem
CREATE TABLE users (
    id_user TINYINT PRIMARY KEY,
    username VARCHAR(30),
    password VARCHAR(35),
    nama VARCHAR(50),
    alamat VARCHAR(150),
    HP VARCHAR(20),
    LEVEL TINYINT(1)
);

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    telp VARCHAR(12),
    alamat TEXT
);

CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(10),
    nama_barang VARCHAR(100),
    harga INT,
    stok INT,
    supplier_id INT,

    FOREIGN KEY (supplier_id) 
	 REFERENCES supplier(id)
);

CREATE TABLE pelanggan (
	 id VARCHAR(20) PRIMARY KEY,
	 nama VARCHAR(100) NOT NULL,
	 jenis_kelamin ENUM('L', 'P'),
	 telp VARCHAR (12),
	 alamat TEXT
);
	 
CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE,
    keterangan TEXT,
    total INT,
    pelanggan_id VARCHAR(20),

    FOREIGN KEY (pelanggan_id) 
	 REFERENCES pelanggan(id)
);

CREATE TABLE transaksi_detail (
	 id_detail INT AUTO_INCREMENT PRIMARY KEY,
	 transaksi_id INT,
	 barang_id INT,
	 harga INT,
	 qty INT,

    FOREIGN KEY (transaksi_id) 
	 REFERENCES transaksi(id),
	 
    FOREIGN KEY (barang_id) 
	 REFERENCES barang(id)
);

CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar DATETIME,
    total INT,
    metode ENUM('TUNAI','TRANSFER','EDC'),
    transaksi_id INT,

    FOREIGN KEY (transaksi_id) 
	 REFERENCES transaksi(id)
);

