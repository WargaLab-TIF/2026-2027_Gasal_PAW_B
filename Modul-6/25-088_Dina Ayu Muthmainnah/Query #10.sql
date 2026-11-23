CREATE DATABASE modul6;
USE modul6;

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    telp VARCHAR(12),
    alamat TEXT
);

CREATE TABLE pelanggan (
    id VARCHAR(20) PRIMARY KEY,
    nama VARCHAR(100),
    jenis_kelamin ENUM('L','P'),
    telp VARCHAR(12),
    alamat TEXT
);

CREATE TABLE user (
    id_user TINYINT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30),
    password VARCHAR(35),
    nama VARCHAR(50),
    alamat VARCHAR(150),
    hp VARCHAR(20),
    level TINYINT
);

CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(10),
    nama_barang VARCHAR(100),
    harga INT,
    stok INT,
    supplier_id INT,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id)
);

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE,
    keterangan TEXT,
    total INT DEFAULT 0,
    pelanggan_id VARCHAR(20),
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
);

CREATE TABLE transaksi_detail (
    transaksi_id INT,
    barang_id INT,
    harga INT,
    qty INT,
    PRIMARY KEY (transaksi_id, barang_id),
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id),
    FOREIGN KEY (barang_id) REFERENCES barang(id)
);

CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar DATETIME,
    total INT,
    metode ENUM('TUNAI','TRANSFER','EDC'),
    transaksi_id INT,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
);