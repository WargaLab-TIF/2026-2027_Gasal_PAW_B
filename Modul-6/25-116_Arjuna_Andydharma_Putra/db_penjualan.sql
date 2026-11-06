CREATE DATABASE IF NOT EXISTS penjualan;
USE penjualan;

CREATE TABLE supplier (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    telp VARCHAR(12),
    alamat TEXT
) ENGINE=InnoDB;

CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(100) NOT NULL UNIQUE,
    nama_barang VARCHAR(100) NOT NULL,
    harga INT NOT NULL DEFAULT 0,
    stok INT NOT NULL DEFAULT 0,
    supplier_id INT,
    FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE pelanggan (
    id VARCHAR(20) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('L','P') NOT NULL,
    telp VARCHAR(12),
    alamat TEXT
) ENGINE=InnoDB;

CREATE TABLE transaksi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_transaksi DATE NOT NULL,
    keterangan TEXT,
    total INT NOT NULL DEFAULT 0,
    pelanggan_id VARCHAR(20),
    FOREIGN KEY (pelanggan_id) REFERENCES pelanggan(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE transaksi_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaksi_id INT NOT NULL,
    barang_id INT NOT NULL,
    harga INT NOT NULL,
    qty INT NOT NULL DEFAULT 1,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (barang_id) REFERENCES barang(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    UNIQUE KEY unique_transaksi_barang (transaksi_id, barang_id)
) ENGINE=InnoDB;

CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    waktu_bayar DATETIME NOT NULL,
    total INT NOT NULL,
    metode ENUM('TUNAI','TRANSFER','EDC') NOT NULL,
    transaksi_id INT NOT NULL,
    FOREIGN KEY (transaksi_id) REFERENCES transaksi(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE user (
    id_user BIGINT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(30) NOT NULL,
    nama VARCHAR(50) NOT NULL,
    alamat VARCHAR(150),
    hp VARCHAR(20),
    level TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

INSERT INTO supplier (nama, telp, alamat) VALUES
('PT Sumber Makmur', '081234567890', 'Jl. Industri No. 12, Jakarta'),
('CV Berkah Jaya', '081298765432', 'Jl. Merdeka No. 45, Bandung'),
('UD Maju Terus', '082112345678', 'Jl. Raya No. 8, Surabaya'),
('PT Global Elektronik', '081345678901', 'Jl. Gatot Subroto No. 21, Jakarta'),
('Toko Bahan Baku Sejahtera', '081567890123', 'Jl. Ahmad Yani No. 33, Semarang');

INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('BRG001', 'Laptop ASUS Vivobook', 8500000, 25, 1),
('BRG002', 'Mouse Wireless Logitech', 250000, 100, 2),
('BRG003', 'Keyboard Mechanical RGB', 750000, 40, 2),
('BRG004', 'Monitor LED 24 inch', 2100000, 30, 4),
('BRG005', 'SSD 512GB NVMe', 950000, 50, 4),
('BRG006', 'Kabel HDMI 2m', 75000, 200, 3),
('BRG007', 'Flashdisk 64GB', 120000, 150, 3),
('BRG008', 'Headset Gaming', 450000, 35, 1),
('BRG009', 'Webcam Full HD', 550000, 20, 5),
('BRG010', 'Powerbank 20000mAh', 350000, 60, 5);

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('PLG001', 'Budi Santoso', 'L', '081111111111', 'Jl. Melati No. 5, Jakarta'),
('PLG002', 'Siti Aminah', 'P', '082222222222', 'Jl. Mawar No. 12, Bandung'),
('PLG003', 'Andi Wijaya', 'L', '083333333333', 'Jl. Kenanga No. 8, Surabaya'),
('PLG004', 'Dewi Lestari', 'P', '084444444444', 'Jl. Anggrek No. 3, Semarang'),
('PLG005', 'Rudi Hartono', 'L', '085555555555', 'Jl. Dahlia No. 17, Yogyakarta');

INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES
('2026-01-05', 'Pembelian rutin', 0, 'PLG001'),
('2026-01-08', 'Pesanan online', 0, 'PLG002'),
('2026-01-10', 'Pembelian kantor', 0, 'PLG003'),
('2026-01-12', 'Restock toko', 0, 'PLG001'),
('2026-01-15', 'Pembelian personal', 0, 'PLG004'),
('2026-01-18', 'Order reseller', 0, 'PLG005'),
('2026-01-20', 'Pembelian urgent', 0, 'PLG002'),
('2026-01-22', 'Pesanan grosir', 0, 'PLG003'),
('2026-01-25', 'Pembelian promo', 0, 'PLG004'),
('2026-01-28', 'Order reguler', 0, 'PLG005'),
('2026-02-01', 'Pembelian tambahan', 0, 'PLG001'),
('2026-02-03', 'Pesanan khusus', 0, 'PLG002');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 8500000, 1),
(1, 2, 250000, 2),
(2, 3, 750000, 1),
(2, 5, 950000, 2),
(3, 4, 2100000, 2),
(3, 6, 75000, 5),
(4, 7, 120000, 10),
(4, 8, 450000, 1),
(5, 9, 550000, 1),
(5, 10, 350000, 2),
(6, 1, 8500000, 1),
(6, 4, 2100000, 1),
(7, 2, 250000, 5),
(7, 3, 750000, 2),
(8, 5, 950000, 3),
(8, 6, 75000, 10),
(9, 7, 120000, 5),
(9, 8, 450000, 2),
(10, 9, 550000, 2),
(10, 10, 350000, 3),
(11, 1, 8500000, 1),
(12, 2, 250000, 4);

UPDATE transaksi t
SET total = (
    SELECT COALESCE(SUM(harga * qty), 0)
    FROM transaksi_detail td
    WHERE td.transaksi_id = t.id
);

INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES
('2026-01-05 10:30:00', 9000000, 'TRANSFER', 1),
('2026-01-08 14:15:00', 2650000, 'TUNAI', 2),
('2026-01-10 09:00:00', 4575000, 'EDC', 3),
('2026-01-12 16:45:00', 1650000, 'TRANSFER', 4),
('2026-01-15 11:20:00', 1250000, 'TUNAI', 5);

INSERT INTO user (username, password, nama, alamat, hp, level) VALUES
('admin', 'admin123', 'Administrator', 'Jl. Kampus No. 1', '081000000001', 1),
('kasir1', 'kasir123', 'Kasir Satu', 'Jl. Ruko No. 2', '081000000002', 2),
('kasir2', 'kasir123', 'Kasir Dua', 'Jl. Ruko No. 3', '081000000003', 2);

SELECT 'Database berhasil dibuat dan diisi data sample' AS status;
SELECT COUNT(*) AS jumlah_supplier FROM supplier;
SELECT COUNT(*) AS jumlah_barang FROM barang;
SELECT COUNT(*) AS jumlah_pelanggan FROM pelanggan;
SELECT COUNT(*) AS jumlah_transaksi FROM transaksi;
SELECT COUNT(*) AS jumlah_detail FROM transaksi_detail;
SELECT COUNT(*) AS jumlah_pembayaran FROM pembayaran;
SELECT COUNT(*) AS jumlah_user FROM user;
