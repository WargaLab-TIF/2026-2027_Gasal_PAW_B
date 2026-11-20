CREATE DATABASE IF NOT EXISTS dbpenjualan;
USE dbpenjualan;

CREATE TABLE user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    username VARCHAR(50) UNIQUE,
    password VARCHAR(100),
    level INT                -- 1 = owner, 2 = kasir
);

CREATE TABLE barang (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    nama_barang VARCHAR(100),
    stok INT,
    harga INT
);

CREATE TABLE supplier (
    id_supplier INT AUTO_INCREMENT PRIMARY KEY,
    nama_supplier VARCHAR(100),
    telp VARCHAR(20),
    alamat TEXT
);

CREATE TABLE pelanggan (
    id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggan VARCHAR(100),
    telp VARCHAR(20),
    alamat TEXT
);

-- Akun contoh (password md5)
INSERT INTO user (nama, username, password, level) VALUES
('Budi', 'owner', MD5('owner123'), 1),
('Sari', 'kasir', MD5('kasir123'), 2);
