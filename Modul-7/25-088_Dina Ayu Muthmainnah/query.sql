CREATE DATABASE db_penjualan;
USE penjualan;

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
-- DATA SUPPLIER
INSERT INTO supplier (nama, telp, alamat) VALUES
('Andi', '081234567801', 'Surabaya'),
('Budi', '081234567802', 'Madura'),
('Citra', '081234567803', 'Malang'),
('Doni', '081234567804', 'Sidoarjo'),
('Eka', '081234567805', 'Gresik');
  
-- DATA PELANGGAN
INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('P001', 'Rina', 'P', '081111111111', 'Surabaya'),
('P002', 'Dina', 'P', '081111111112', 'Madura'),
('P003', 'Andi', 'L', '081111111113', 'Malang'),
('P004', 'Budi', 'L', '081111111114', 'Gresik'),
('P005', 'Siti', 'P', '081111111115', 'Sidoarjo');

-- DATA USER
INSERT INTO `user`  (username, password, nama, alamat, hp, level) VALUES
INSERT INTO `user`  (username, password, nama, alamat, hp, level) VALUES
(1, 'admin', '12345', 'Admin', 'Surabaya', '081222222221', 1),
(2, 'kasir1', '12345', 'Kasir Satu', 'Madura', '081222222222', 2),
(3, 'kasir2', '12345', 'Kasir Dua', 'Malang', '081222222223', 2),
(4, 'staff1', '12345', 'Staff Satu', 'Gresik', '081222222224', 3),
(5, 'staff2', '12345', 'Staff Dua', 'Sidoarjo', '081222222225', 3);
 
-- DATA BARANG
INSERT INTO barang
(kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('B001', 'Buku', 5000, 100, 1),
('B002', 'Pulpen', 3000, 100, 2),
('B003', 'Pensil', 2000, 100, 3),
('B004', 'Penghapus', 1500, 100, 4),
('B005', 'Penggaris', 4000, 100, 5);
 
-- DATA TRANSAKSI
INSERT INTO transaksi
(waktu_transaksi, keterangan, total, pelanggan_id) VALUES
('2026-11-01', 'Pembelian 1', 0, 'P001'),
('2026-11-01', 'Pembelian 2', 0, 'P002'),
('2026-11-02', 'Pembelian 3', 0, 'P003'),
('2026-11-02', 'Pembelian 4', 0, 'P004'),
('2026-11-03', 'Pembelian 5', 0, 'P005'),
('2026-11-03', 'Pembelian 6', 0, 'P001'),
('2026-11-04', 'Pembelian 7', 0, 'P002'),
('2026-11-04', 'Pembelian 8', 0, 'P003'),
('2026-11-05', 'Pembelian 9', 0, 'P004'),
('2026-11-05', 'Pembelian 10', 0, 'P005');

