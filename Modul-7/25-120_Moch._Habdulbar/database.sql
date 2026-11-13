CREATE DATABASE IF NOT EXISTS penjualan;
USE penjualan;

-- ================= STRUKTUR TABEL =================

CREATE TABLE supplier (
    id     INT AUTO_INCREMENT PRIMARY KEY,
    nama   VARCHAR(100) NOT NULL,
    telp   VARCHAR(12),
    alamat TEXT
) ENGINE=InnoDB;

CREATE TABLE barang (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(10) NOT NULL UNIQUE,
    nama_barang VARCHAR(100) NOT NULL,
    harga       INT NOT NULL,
    stok        INT NOT NULL,
    supplier_id INT NOT NULL,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id)
) ENGINE=InnoDB;

CREATE TABLE pelanggan (
    id            VARCHAR(20) PRIMARY KEY,
    nama          VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    telp          VARCHAR(12),
    alamat        TEXT
) ENGINE=InnoDB;

CREATE TABLE user (
    id_user  TINYINT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(35) NOT NULL,
    nama     VARCHAR(50),
    alamat   VARCHAR(150),
    hp       VARCHAR(20),
    level    TINYINT(1)
) ENGINE=InnoDB;

CREATE TABLE transaksi (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE NOT NULL,
    keterangan      TEXT,
    total           INT NOT NULL DEFAULT 0,
    pelanggan_id    VARCHAR(20) NOT NULL,
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id)
) ENGINE=InnoDB;

-- Primary key gabungan: barang yang sama tidak bisa masuk 2x di satu transaksi
CREATE TABLE transaksi_detail (
    transaksi_id INT NOT NULL,
    barang_id    INT NOT NULL,
    harga        INT NOT NULL,
    qty          INT NOT NULL,
    PRIMARY KEY (transaksi_id, barang_id),
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE,
    FOREIGN KEY (barang_id)    REFERENCES barang(id)    ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE pembayaran (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar  DATETIME NOT NULL,
    total        INT NOT NULL,
    metode       ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
    transaksi_id INT NOT NULL,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ================= DATA MASTER (minimal 5) =================

INSERT INTO supplier (nama, telp, alamat) VALUES
('PT Sumber Pangan',  '031111111', 'Surabaya'),
('CV Maju Jaya',      '031222222', 'Sidoarjo'),
('UD Tani Makmur',    '031333333', 'Malang'),
('PT Kopi Nusantara', '031444444', 'Jember'),
('CV Teh Sejahtera',  '031555555', 'Pasuruan');

INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('BRG001', 'Beras 5kg',        65000, 50, 1),
('BRG002', 'Minyak Goreng 2L', 35000, 40, 1),
('BRG003', 'Gula Pasir 1kg',   16000, 60, 2),
('BRG004', 'Telur 1kg',        28000, 30, 3),
('BRG005', 'Kopi Bubuk 200g',  22000, 45, 4),
('BRG006', 'Teh Celup',        12000, 70, 5),
('BRG007', 'Sabun Mandi',       4500, 100, 2),
('BRG008', 'Sampo 170ml',      18000, 40, 3),
('BRG009', 'Mie Instan',        3500, 200, 1),
('BRG010', 'Tepung Terigu 1kg',12500, 55, 2);

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('P001', 'Budi Santoso', 'L', '081111111', 'Bangkalan'),
('P002', 'Siti Aminah',  'P', '081222222', 'Bangkalan'),
('P003', 'Ahmad Fauzi',  'L', '081333333', 'Sampang'),
('P004', 'Dewi Lestari', 'P', '081444444', 'Pamekasan'),
('P005', 'Rudi Hartono', 'L', '081555555', 'Surabaya');

INSERT INTO user (username, password, nama, alamat, hp, level) VALUES
('admin',  MD5('admin123'),  'Administrator', 'Bangkalan', '082111111', 1),
('kasir1', MD5('kasir123'),  'Kasir Satu',    'Bangkalan', '082222222', 2),
('kasir2', MD5('kasir123'),  'Kasir Dua',     'Sampang',   '082333333', 2),
('gudang', MD5('gudang123'), 'Staf Gudang',   'Surabaya',  '082444444', 3),
('owner',  MD5('owner123'),  'Pemilik Toko',  'Bangkalan', '082555555', 1);

-- ================= DATA TRANSAKSI (10 data) =================

INSERT INTO transaksi (waktu_transaksi, keterangan, pelanggan_id) VALUES
('2026-10-01', 'Belanja bulanan', 'P001'),
('2026-10-02', 'Belanja harian',  'P002'),
('2026-10-03', 'Beli telur',      'P003'),
('2026-10-05', 'Belanja harian',  'P001'),
('2026-10-07', 'Stok warung',     'P004'),
('2026-10-10', 'Belanja harian',  'P005'),
('2026-10-12', 'Belanja mingguan','P002'),
('2026-10-15', 'Belanja harian',  'P003'),
('2026-10-20', 'Beli beras',      'P004'),
('2026-10-25', 'Belanja mingguan','P005');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 65000, 1), (1, 3, 16000, 2),
(2, 2, 35000, 1), (2, 5, 22000, 1),
(3, 4, 28000, 2),
(4, 6, 12000, 3), (4, 3, 16000, 1),
(5, 1, 65000, 2), (5, 2, 35000, 2),
(6, 5, 22000, 2), (6, 6, 12000, 1),
(7, 3, 16000, 3), (7, 4, 28000, 1),
(8, 2, 35000, 1), (8, 6, 12000, 2), (8, 5, 22000, 1),
(9, 1, 65000, 1),
(10, 4, 28000, 3), (10, 3, 16000, 2);

-- Hitung total setiap transaksi dari detailnya
UPDATE transaksi t
SET total = (SELECT SUM(harga * qty) FROM transaksi_detail WHERE transaksi_id = t.id);

-- Satu pembayaran untuk tiap transaksi (10 data), nilainya sama dengan total transaksi
INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id)
SELECT CONCAT(waktu_transaksi, ' 10:00:00'), total, 'TUNAI', id
FROM transaksi;
