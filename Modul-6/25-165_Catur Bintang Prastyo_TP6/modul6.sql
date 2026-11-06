DROP DATABASE IF EXISTS penjualan;
CREATE DATABASE penjualan;
USE penjualan;

CREATE TABLE supplier (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  telp VARCHAR(12),
  alamat TEXT
);

CREATE TABLE barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(10) UNIQUE,
  nama_barang VARCHAR(100),
  harga INT,
  stok INT,
  supplier_id INT,
  FOREIGN KEY (supplier_id) REFERENCES supplier(id)
);

CREATE TABLE pelanggan (
  id VARCHAR(20) PRIMARY KEY,
  nama VARCHAR(100),
  jenis_kelamin ENUM('L','P'),
  telp VARCHAR(12),
  alamat TEXT
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
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE,
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

CREATE TABLE user (
  id_user TINYINT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30),
  password VARCHAR(35),
  nama VARCHAR(50),
  alamat VARCHAR(150),
  hp VARCHAR(20),
  level TINYINT(1)
);

INSERT INTO supplier (nama, telp, alamat) VALUES
('PT Sumber Makmur', '031111111', 'Surabaya'),
('CV Jaya Abadi', '031222222', 'Sidoarjo'),
('UD Sentosa', '031333333', 'Gresik'),
('PT Maju Bersama', '031444444', 'Malang'),
('CV Berkah', '031555555', 'Madura');

INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('BRG001', 'Beras 5kg', 65000, 50, 1),
('BRG002', 'Minyak Goreng 1L', 18000, 100, 2),
('BRG003', 'Gula Pasir 1kg', 16000, 80, 1),
('BRG004', 'Kopi Bubuk 200g', 22000, 40, 3),
('BRG005', 'Teh Celup 25s', 9000, 120, 4),
('BRG006', 'Mie Instan', 3000, 200, 5);

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('P001', 'Budi Santoso', 'L', '081100000001', 'Surabaya'),
('P002', 'Siti Aminah', 'P', '081100000002', 'Gresik'),
('P003', 'Andi Wijaya', 'L', '081100000003', 'Bangkalan'),
('P004', 'Dewi Lestari', 'P', '081100000004', 'Sidoarjo'),
('P005', 'Rudi Hartono', 'L', '081100000005', 'Pamekasan');

INSERT INTO transaksi (id, waktu_transaksi, keterangan, total, pelanggan_id) VALUES
(1, '2026-10-01', 'Pembelian bulanan', 0, 'P001'),
(2, '2026-10-02', 'Belanja harian', 0, 'P002'),
(3, '2026-10-03', 'Stok rumah tangga', 0, 'P003'),
(4, '2026-10-05', 'Belanja mingguan', 0, 'P004'),
(5, '2026-10-06', 'Pembelian rutin', 0, 'P005'),
(6, '2026-10-08', 'Belanja harian', 0, 'P001'),
(7, '2026-10-10', 'Pesanan khusus', 0, 'P002'),
(8, '2026-10-12', 'Belanja mingguan', 0, 'P003'),
(9, '2026-10-15', 'Pembelian bulanan', 0, 'P004'),
(10, '2026-10-18', 'Stok tambahan', 0, 'P005');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 65000, 2), (1, 2, 18000, 3),
(2, 3, 16000, 1), (2, 6, 3000, 5),
(3, 4, 22000, 2), (3, 5, 9000, 1),
(4, 1, 65000, 1), (4, 3, 16000, 2),
(5, 2, 18000, 4), (5, 6, 3000, 10),
(6, 5, 9000, 3), (6, 4, 22000, 1),
(7, 1, 65000, 3), (7, 3, 16000, 1),
(8, 2, 18000, 2), (8, 5, 9000, 2),
(9, 4, 22000, 3), (9, 6, 3000, 6),
(10, 1, 65000, 1), (10, 2, 18000, 2);

UPDATE transaksi t
SET total = (SELECT SUM(d.harga * d.qty) FROM transaksi_detail d WHERE d.transaksi_id = t.id);