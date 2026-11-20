DROP DATABASE IF EXISTS dbpenjualan;
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
    PRIMARY KEY(id_user, username)
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

INSERT INTO supplier (nama, telp, alamat) VALUES
('PT Sumber Elektronik', '081234567890', 'Jl. Merdeka No. 10, Jakarta'),
('CV Maju Jaya', '085678901234', 'Jl. Ahmad Yani No. 25, Surabaya'),
('UD Berkah Pangan', '081987654321', 'Jl. Pahlawan No. 5, Malang'),
('PT Global Tech', '082112233445', 'Jl. Sudirman No. 88, Bandung'),
('CV Sentosa Abadi', '087788990011', 'Jl. Diponegoro No. 12, Semarang');

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('P001', 'Budi Santoso', 'L', '081111222333', 'Jl. Kenanga No. 3'),
('P002', 'Siti Aminah', 'P', '082222333444', 'Jl. Melati No. 7'),
('P003', 'Joko Widodo', 'L', '083333444555', 'Jl. Anggrek No. 12'),
('P004', 'Dewi Lestari', 'P', '084444555666', 'Jl. Mawar No. 15'),
('P005', 'Ahmad Dani', 'L', '085555666777', 'Jl. Cempaka No. 20');

INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('B001', 'Laptop ASUS ROG', 15000000, 10, 1),
('B002', 'Mouse Logitech Wireless', 250000, 50, 2),
('B003', 'Keyboard Mechanical', 750000, 25, 2),
('B004', 'Monitor LG 24 Inch', 2000000, 15, 4),
('B005', 'Headset Gaming RGB', 450000, 30, 1);

INSERT INTO users (username, password, nama, alamat, hp, level) VALUES
('owner', MD5('owner'), 'Budi', 'Surabaya', '08123456789', 1),
('kasir', MD5('kasir'), 'Siti', 'Surabaya', '08987654321', 2);

INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES
('2026-11-01', 'Penjualan offline toko', 15250000, 'P001'),
('2026-11-01', 'Promo awal bulan', 950000, 'P002'),
('2026-11-02', 'Pembelian aksesoris', 2450000, 'P003'),
('2026-11-02', 'Grosir keyboard', 1500000, 'P004'),
('2026-11-03', 'Pesanan online marketplace', 15000000, 'P005'),
('2026-11-03', 'Keperluan kantor', 270000, 'P001'),
('2026-11-04', 'Pembelian reguler', 2000000, 'P002'),
('2026-11-04', 'Paket gaming bundle', 15450000, 'P003'),
('2026-11-05', 'Penjualan kasir 1', 700000, 'P004'),
('2026-11-05', 'Transaksi akhir hari', 450000, 'P005');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 15000000, 1),
(1, 2, 250000, 1),
(2, 2, 250000, 1),
(2, 3, 700000, 1),
(3, 3, 750000, 2),
(3, 4, 1950000, 1),
(4, 3, 750000, 2),
(5, 1, 15000000, 1),
(6, 2, 270000, 1),
(7, 4, 2000000, 1),
(8, 1, 15000000, 1),
(8, 5, 450000, 1),
(9, 2, 250000, 1),
(9, 3, 450000, 1),
(10, 5, 450000, 1);