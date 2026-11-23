INSERT INTO supplier (id, nama, telp, alamat) VALUES
(1, 'PT Sumber Makmur', '08123456701', 'Jl. Rungkut No. 10 Surabaya'),
(2, 'CV Tani Jaya', '08123456702', 'Jl. Diponegoro No. 25 Surabaya'),
(3, 'PT Indo Pangan', '08123456703', 'Jl. Ahmad Yani No. 8 Sidoarjo'),
(4, 'UD Berkah Abadi', '08123456704', 'Jl. Raya Gresik No. 15 Gresik'),
(5, 'PT Bersih Sejahtera', '08123456705', 'Jl. Pemuda No. 30 Surabaya');

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('PLG001', 'Budi Santoso', 'L', '08111111101', 'Jl. Kenjeran No. 1 Surabaya'),
('PLG002', 'Siti Aminah', 'P', '08111111102', 'Jl. Darmo No. 2 Surabaya'),
('PLG003', 'Agus Wijaya', 'L', '08111111103', 'Jl. Gubeng No. 3 Surabaya'),
('PLG004', 'Dewi Lestari', 'P', '08111111104', 'Jl. Manyar No. 4 Surabaya'),
('PLG005', 'Rudi Hartono', 'L', '08111111105', 'Jl. Wonokromo No. 5 Surabaya');

INSERT INTO barang (id, kode_barang, nama_barang, harga, stok, supplier_id) VALUES
(1, 'BRG001', 'Beras 5 Kg', 65000, 100, 1),
(2, 'BRG002', 'Minyak Goreng 2 L', 38000, 80, 1),
(3, 'BRG003', 'Gula Pasir 1 Kg', 17000, 120, 2),
(4, 'BRG004', 'Telur Ayam 1 Kg', 28000, 60, 2),
(5, 'BRG005', 'Mie Instan', 3500, 500, 3),
(6, 'BRG006', 'Kopi Sachet', 2000, 300, 3),
(7, 'BRG007', 'Sabun Mandi', 4500, 150, 4),
(8, 'BRG008', 'Deterjen 1 Kg', 22000, 90, 5);

INSERT INTO transaksi (id, waktu_transaksi, keterangan, total, pelanggan_id) VALUES
(1, '2026-10-01', 'Belanja bulanan', 99000, 'PLG001'),
(2, '2026-10-02', 'Belanja harian', 73000, 'PLG002'),
(3, '2026-10-03', 'Belanja harian', 75000, 'PLG003'),
(4, '2026-10-05', 'Belanja harian', 39000, 'PLG004'),
(5, '2026-10-07', 'Belanja bulanan', 206000, 'PLG005'),
(6, '2026-10-09', 'Stok warung', 90000, 'PLG001'),
(7, '2026-10-12', 'Belanja harian', 57500, 'PLG002'),
(8, '2026-10-15', 'Belanja harian', 79000, 'PLG003'),
(9, '2026-10-18', 'Belanja mingguan', 90500, 'PLG004'),
(10, '2026-10-20', 'Belanja mingguan', 88000, 'PLG005');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 65000, 1),
(1, 3, 17000, 2),
(2, 2, 38000, 1),
(2, 5, 3500, 10),
(3, 4, 28000, 2),
(3, 6, 2000, 5),
(3, 7, 4500, 2),
(4, 8, 22000, 1),
(4, 3, 17000, 1),
(5, 1, 65000, 2),
(5, 2, 38000, 2),
(6, 5, 3500, 20),
(6, 6, 2000, 10),
(7, 7, 4500, 3),
(7, 8, 22000, 2),
(8, 4, 28000, 1),
(8, 3, 17000, 3),
(9, 1, 65000, 1),
(9, 6, 2000, 4),
(9, 5, 3500, 5),
(10, 2, 38000, 1),
(10, 4, 28000, 1),
(10, 8, 22000, 1);

INSERT INTO pembayaran (id, waktu_bayar, total, metode, transaksi_id) VALUES
(1, '2026-10-01 10:15:00', 99000, 'TUNAI', 1),
(2, '2026-10-02 11:30:00', 73000, 'TRANSFER', 2),
(3, '2026-10-03 09:45:00', 75000, 'TUNAI', 3),
(4, '2026-10-05 14:20:00', 39000, 'EDC', 4),
(5, '2026-10-07 16:00:00', 206000, 'TRANSFER', 5),
(6, '2026-10-09 08:50:00', 90000, 'TUNAI', 6),
(7, '2026-10-12 13:10:00', 57500, 'EDC', 7),
(8, '2026-10-15 15:25:00', 79000, 'TUNAI', 8),
(9, '2026-10-18 10:40:00', 90500, 'TRANSFER', 9),
(10, '2026-10-20 12:05:00', 88000, 'EDC', 10);