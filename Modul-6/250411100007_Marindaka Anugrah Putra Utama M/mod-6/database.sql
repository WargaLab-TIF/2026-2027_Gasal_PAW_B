CREATE DATABASE IF NOT EXISTS penjualan;
USE penjualan;

CREATE TABLE supplier (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  telp VARCHAR(12),
  alamat TEXT
);

CREATE TABLE barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(10) NOT NULL UNIQUE,
  nama_barang VARCHAR(100) NOT NULL,
  harga INT NOT NULL,
  stok INT NOT NULL,
  supplier_id INT NOT NULL,
  FOREIGN KEY (supplier_id) REFERENCES supplier(id)
);

CREATE TABLE pelanggan (
  id VARCHAR(20) PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  telp VARCHAR(12),
  alamat TEXT
);

CREATE TABLE transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
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
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE,
  FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE RESTRICT
);

CREATE TABLE pembayaran (
  id INT AUTO_INCREMENT PRIMARY KEY,
  waktu_bayar DATETIME NOT NULL,
  total INT NOT NULL,
  metode ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
  transaksi_id INT NOT NULL,
  FOREIGN KEY (transaksi_id) REFERENCES transaksi(id)
);

CREATE TABLE user (
  id_user TINYINT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(30) NOT NULL UNIQUE,
  password VARCHAR(35) NOT NULL,
  nama VARCHAR(50),
  alamat VARCHAR(150),
  hp VARCHAR(20),
  level TINYINT(1) NOT NULL DEFAULT 1
);

INSERT INTO supplier (nama, telp, alamat) VALUES
('PT Maju Jaya','031111111','Surabaya'),
('CV Sumber Rezeki','031222222','Sidoarjo'),
('UD Makmur','031333333','Gresik'),
('PT Sentosa Abadi','031444444','Malang'),
('CV Berkah Selalu','031555555','Bangkalan');

INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('BRG001','Beras 5kg',65000,50,1),
('BRG002','Minyak Goreng 2L',38000,40,2),
('BRG003','Gula Pasir 1kg',16000,60,3),
('BRG004','Telur 1kg',28000,30,4),
('BRG005','Kopi Bubuk 200g',22000,45,5),
('BRG006','Teh Celup',12000,70,1);

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('P001','Andi','L','081111111','Bangkalan'),
('P002','Siti','P','081222222','Sampang'),
('P003','Budi','L','081333333','Pamekasan'),
('P004','Dewi','P','081444444','Sumenep'),
('P005','Rina','P','081555555','Surabaya');

INSERT INTO user (username,password,nama,alamat,hp,level) VALUES
('admin',MD5('admin'),'Administrator','Bangkalan','081000000',1);

INSERT INTO transaksi (waktu_transaksi, keterangan, pelanggan_id) VALUES
('2026-11-01','Belanja bulanan','P001'),
('2026-11-01','Tunai','P002'),
('2026-11-02','Pesanan warung','P003'),
('2026-11-02','Tunai','P004'),
('2026-11-03','Belanja mingguan','P005'),
('2026-11-03','Transfer','P001'),
('2026-11-04','Tunai','P002'),
('2026-11-04','Pesanan kantor','P003'),
('2026-11-05','Tunai','P004'),
('2026-11-05','EDC','P005');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1,1,65000,1),(1,2,38000,2),
(2,3,16000,3),
(3,4,28000,2),(3,5,22000,1),
(4,6,12000,5),
(5,1,65000,2),(5,3,16000,1),
(6,2,38000,1),
(7,5,22000,2),
(8,4,28000,1),(8,6,12000,2),
(9,1,65000,1),
(10,2,38000,3),(10,5,22000,1);

UPDATE transaksi t SET total = (SELECT COALESCE(SUM(harga*qty),0) FROM transaksi_detail d WHERE d.transaksi_id = t.id);

INSERT INTO pembayaran (waktu_bayar,total,metode,transaksi_id)
SELECT NOW(), total, 'TUNAI', id FROM transaksi WHERE id <= 3;
