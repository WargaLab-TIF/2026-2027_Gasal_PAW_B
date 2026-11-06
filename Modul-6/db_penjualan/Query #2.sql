USE db_penjualan;

INSERT INTO users (id_user, username, password, nama, alamat, HP, LEVEL) VALUES
(1, 'admin', 'admin123', 'Administrator', 'Bangkalan', '081234567890', 1),
(2, 'kasir1', 'kasir123', 'jangkrik', 'Surabaya', '082345678901', 2),
(3, 'kasir2', 'kasir456', 'ayam', 'Madura', '083456789012', 2),
(4, 'staff1', 'staff123', 'kudanil', 'Sidoarjo', '084567890123', 3),
(5, 'staff2', 'staff456', 'hiu', 'Gresik', '085678901234', 3);

INSERT INTO supplier (nama, telp, alamat) VALUES
('PT Ular Makmur', '081234567890', 'Jakarta'),
('CV Kambing Abadi', '082345678901', 'Surabaya'),
('PT Maju Bersama', '083456789012', 'Bali'),
('CV Berkah Ayam', '084567890123', 'Nganjuk'),
('PT Sehat Selalu', '085678901234', 'Gresik');

INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('BR001', 'Es Krim', 5000, 100, 1),
('BR002', 'Sayur Kol', 3000, 150, 2),
('BR003', 'Konsentrat', 2000, 200, 3),
('BR004', 'Wortel', 1500, 100, 4),
('BR005', 'Tikus', 4000, 80, 5);

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('PL001', 'Ayam', 'L', '081111111111', 'Jakarta'),
('PL002', 'Kelinci', 'P', '082222222222', 'Surabaya'),
('PL003', 'Rubah', 'L', '083333333333', 'Nganjuk'),
('PL004', 'ular', 'P', '084444444444', 'Bali'),
('PL005', 'Kangguru', 'P', '085555555555', 'Gresik');

INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES
('2026-11-01', 'Sayur', 13000, 'PL001'),
('2026-11-02', 'Es Krim', 10000, 'PL002'),
('2026-11-03', 'Makanan', 14000, 'PL003'),
('2026-11-04', 'Sayur', 9000, 'PL004'),
('2026-11-05', 'Sayur Mayur', 7000, 'PL005'),
('2026-11-06', 'Es Krim', 5000, 'PL001'),
('2026-11-07', 'Sayur Kol', 6000, 'PL002'),
('2026-11-08', 'Konsentrat', 6000, 'PL003'),
('2026-11-09', 'Tikus', 8000, 'PL004'),
('2026-11-10', 'Wortel', 6000, 'PL005');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 5000, 2),
(1, 2, 3000, 1),
(2, 1, 5000, 2),
(3, 3, 2000, 5),
(3, 5, 4000, 1),
(4, 2, 3000, 3),
(5, 4, 1500, 2),
(5, 5, 4000, 1),
(6, 1, 5000, 1),
(7, 2, 3000, 2),
(8, 3, 2000, 3),
(9, 5, 4000, 2),
(10, 4, 1500, 4);

INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES
('2026-11-01 10:00:00', 13000, 'TUNAI', 1),
('2026-11-02 11:00:00', 10000, 'TRANSFER', 2),
('2026-11-03 12:00:00', 14000, 'EDC', 3),
('2026-11-04 13:00:00', 9000, 'TUNAI', 4),
('2026-11-05 14:00:00', 7000, 'TRANSFER', 5),
('2026-11-06 09:00:00', 5000, 'TUNAI', 6),
('2026-11-07 10:00:00', 6000, 'EDC', 7),
('2026-11-08 11:00:00', 6000, 'TRANSFER', 8),
('2026-11-09 12:00:00', 8000, 'TUNAI', 9),
('2026-11-10 13:00:00', 6000, 'EDC', 10);