DROP DATABASE dbpenjualan;
CREATE DATABASE dbpenjualan;
USE dbpenjualan;

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(12) NOT NULL,
    alamat TEXT NOT NULL
);

CREATE TABLE pelanggan (
    id VARCHAR(20) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    telp VARCHAR(12) NOT NULL,
    alamat TEXT NOT NULL
);

CREATE TABLE users (
    id_user TINYINT AUTO_INCREMENT,
    username VARCHAR(30),
    password VARCHAR(35) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    alamat VARCHAR(150) NOT NULL,
    hp VARCHAR(20) NOT NULL,
    level TINYINT(1) NOT NULL,
    PRIMARY KEY(id_user,username)
);

CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(10) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL,
    supplier_id INT,
    CONSTRAINT fk_supplier_id FOREIGN KEY (supplier_id) REFERENCES supplier(id)
);

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE NOT NULL,
    keterangan TEXT NOT NULL,
    total INT NOT NULL,
    pelanggan_id VARCHAR(20),
    CONSTRAINT fk_pelanggan_id FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
);

CREATE TABLE transaksi_detail (
    transaksi_id INT,
    barang_id INT,
    harga INT NOT NULL,
    qty INT NOT NULL,
    CONSTRAINT fk_barang_id FOREIGN KEY (barang_id) REFERENCES barang(id),
    CONSTRAINT fk_transaksi_id FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
);

CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar DATETIME NOT NULL,
    total INT NOT NULL,
    metode ENUM('TUNAI', 'TRANSFER', 'EDC') NOT NULL,
    transaksi_id INT,
    CONSTRAINT fk_transaksi2_id FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
);