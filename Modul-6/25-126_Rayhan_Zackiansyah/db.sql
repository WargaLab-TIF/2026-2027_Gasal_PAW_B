CREATE DATABASE IF NOT EXISTS penjualan;
USE penjualan;

CREATE TABLE supplier (
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  nama VARCHAR(100) NOT NULL,
  telp VARCHAR(12),
  alamat TEXT
);

CREATE TABLE pelanggan (
  id VARCHAR(20) PRIMARY KEY NOT NULL,
  nama VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  telp VARCHAR(12),
  alamat TEXT
);

CREATE TABLE user (
  id_user TINYINT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  username VARCHAR(30) NOT NULL,
  password VARCHAR(35) NOT NULL,
  nama VARCHAR(50),
  alamat VARCHAR(150),
  hp VARCHAR(20),
  level TINYINT(1)
);

CREATE TABLE barang (
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  kode_barang VARCHAR(10) NOT NULL,
  nama_barang VARCHAR(100) NOT NULL,
  harga INT NOT NULL,
  stok INT NOT NULL,
  supplier_id INT NOT NULL,
  FOREIGN KEY (supplier_id) REFERENCES supplier(id)
);

CREATE TABLE transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  waktu_transaksi DATE NOT NULL,
  keterangan TEXT,
  total INT NOT NULL DEFAULT 0,
  pelanggan_id VARCHAR(20) NOT NULL,
  FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
);

CREATE TABLE transaksi_detail (
  transaksi_id INT NOT NULL,
  barang_id INT NOT NULL,
  harga INT NOT NULL,
  qty INT NOT NULL,
  PRIMARY KEY (transaksi_id, barang_id),
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id),
  FOREIGN KEY (barang_id) REFERENCES barang(id)
);

CREATE TABLE pembayaran (
  id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  waktu_bayar DATETIME NOT NULL,
  total INT NOT NULL,
  metode ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
  transaksi_id INT NOT NULL,
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
);

INSERT INTO supplier (id, nama, telp, alamat) VALUES
(1, 'PT Sumber Pangan', '031555101', 'Jl. Raya Surabaya No. 10'),
(2, 'CV Maju Jaya', '031555102', 'Jl. Pahlawan No. 22'),
(3, 'UD Berkah Abadi', '031555103', 'Jl. Merdeka No. 5'),
(4, 'PT Indo Mie', '031555104', 'Jl. Industri No. 8'),
(5, 'CV Bersih Sejahtera', '031555105', 'Jl. Diponegoro No. 15');

INSERT INTO barang (id, kode_barang, nama_barang, harga, stok, supplier_id) VALUES
(1, 'BRG001', 'Beras 5kg', 65000, 100, 1),
(2, 'BRG002', 'Minyak Goreng 2L', 38000, 80, 1),
(3, 'BRG003', 'Gula Pasir 1kg', 16000, 120, 2),
(4, 'BRG004', 'Kopi Bubuk 200g', 22000, 60, 2),
(5, 'BRG005', 'Teh Celup 25s', 9000, 90, 3),
(6, 'BRG006', 'Susu UHT 1L', 18000, 70, 3),
(7, 'BRG007', 'Mi Instan', 3500, 200, 4),
(8, 'BRG008', 'Sabun Mandi', 4500, 150, 5);

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('PLG001', 'Budi Santoso', 'L', '081234500001', 'Bangkalan'),
('PLG002', 'Siti Aminah', 'P', '081234500002', 'Sampang'),
('PLG003', 'Ahmad Fauzi', 'L', '081234500003', 'Pamekasan'),
('PLG004', 'Dewi Lestari', 'P', '081234500004', 'Sumenep'),
('PLG005', 'Rina Wulandari', 'P', '081234500005', 'Surabaya');

INSERT INTO user (id_user, username, password, nama, alamat, hp, level) VALUES
(1, 'admin', MD5('admin123'), 'Administrator', 'Bangkalan', '081200000001', 1),
(2, 'kasir', MD5('kasir123'), 'Kasir Toko', 'Bangkalan', '081200000002', 2);

INSERT INTO transaksi (id, waktu_transaksi, keterangan, total, pelanggan_id) VALUES
(1, '2026-10-01', 'Belanja bulanan', 0, 'PLG001'),
(2, '2026-10-03', 'Pembelian harian', 0, 'PLG002'),
(3, '2026-10-05', 'Kebutuhan kantor', 0, 'PLG003'),
(4, '2026-10-08', 'Pembelian sabun', 0, 'PLG004'),
(5, '2026-10-10', 'Belanja mingguan', 0, 'PLG005'),
(6, '2026-10-12', 'Pembelian dapur', 0, 'PLG001'),
(7, '2026-10-15', 'Pembelian susu', 0, 'PLG002'),
(8, '2026-10-18', 'Belanja campur', 0, 'PLG003'),
(9, '2026-10-20', 'Pembelian beras', 0, 'PLG004'),
(10, '2026-10-25', 'Belanja akhir bulan', 0, 'PLG005');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 65000, 2), (1, 3, 16000, 1),
(2, 2, 38000, 1), (2, 7, 3500, 10),
(3, 4, 22000, 2), (3, 5, 9000, 3), (3, 6, 18000, 1),
(4, 8, 4500, 5),
(5, 1, 65000, 1), (5, 2, 38000, 2),
(6, 3, 16000, 3), (6, 7, 3500, 5),
(7, 6, 18000, 4),
(8, 5, 9000, 2), (8, 8, 4500, 2), (8, 4, 22000, 1),
(9, 1, 65000, 3),
(10, 2, 38000, 1), (10, 3, 16000, 2), (10, 7, 3500, 4);

UPDATE transaksi t
SET t.total = (SELECT SUM(d.harga * d.qty) FROM transaksi_detail d WHERE d.transaksi_id = t.id);

INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id)
SELECT CONCAT(waktu_transaksi, ' 10:00:00'), total, 'TUNAI', id FROM transaksi WHERE id IN (1, 2, 3, 4, 5);
INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id)
SELECT CONCAT(waktu_transaksi, ' 14:00:00'), total, 'TRANSFER', id FROM transaksi WHERE id IN (6, 7, 8);
INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id)
SELECT CONCAT(waktu_transaksi, ' 16:00:00'), total, 'EDC', id FROM transaksi WHERE id IN (9, 10);

INSERT INTO barang (id, kode_barang, nama_barang, harga, stok, supplier_id) VALUES
(9, 'BRG009', 'Barang Uji Hapus', 10000, 10, 5);
