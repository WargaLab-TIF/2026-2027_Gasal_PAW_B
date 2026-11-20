CREATE DATABASE IF NOT EXISTS penjualan;
USE penjualan;

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(12),
    alamat TEXT
) ENGINE=INNODB;

CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(10) NOT NULL,
    nama_barang VARCHAR(100) NOT NULL,
    harga INT NOT NULL,
    stok INT NOT NULL,
    supplier_id INT NOT NULL,

    UNIQUE (kode_barang),

    FOREIGN KEY (supplier_id)
    REFERENCES supplier(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=INNODB;

CREATE TABLE pelanggan (
    id VARCHAR(20) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P'),
    telp VARCHAR(12),
    alamat TEXT
) ENGINE=INNODB;

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE NOT NULL,
    keterangan TEXT,
    total INT DEFAULT 0,
    pelanggan_id VARCHAR(20),

    FOREIGN KEY (pelanggan_id)
    REFERENCES pelanggan(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=INNODB;