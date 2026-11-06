INSERT INTO transaksi (id, waktu_transaksi, keterangan, total, pelanggan_id) VALUES
(1, '2026-11-01', 'Pembelian alat tulis', 10000, 'PLG001'),
(2, '2026-11-01', 'Pembelian pulpen', 6000, 'PLG002'),
(3, '2026-11-02', 'Pembelian buku', 15000, 'PLG003'),
(4, '2026-11-02', 'Pembelian penggaris', 8000, 'PLG004'),
(5, '2026-11-03', 'Pembelian pensil', 4000, 'PLG005'),
(6, '2026-11-03', 'Pembelian buku tulis', 5000, 'PLG001'),
(7, '2026-11-04', 'Pembelian pulpen', 9000, 'PLG002'),
(8, '2026-11-04', 'Pembelian penghapus', 3000, 'PLG003'),
(9, '2026-11-05', 'Pembelian penggaris', 12000, 'PLG004'),
(10, '2026-11-05', 'Pembelian alat tulis', 10000, 'PLG005');

INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES
(1, 1, 5000, 2),
(2, 2, 3000, 2),
(3, 1, 5000, 3),
(4, 5, 4000, 2),
(5, 3, 2000, 2),
(6, 1, 5000, 1),
(7, 2, 3000, 3),
(8, 4, 1500, 2),
(9, 5, 4000, 3),
(10, 1, 5000, 2);

INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES
('2026-11-01 09:00:00', 10000, 'TUNAI', 1),
('2026-11-01 10:00:00', 6000, 'TRANSFER', 2),
('2026-11-02 09:30:00', 15000, 'EDC', 3),
('2026-11-02 11:00:00', 8000, 'TUNAI', 4),
('2026-11-03 08:30:00', 4000, 'TRANSFER', 5),
('2026-11-03 10:00:00', 5000, 'TUNAI', 6),
('2026-11-04 09:00:00', 9000, 'EDC', 7),
('2026-11-04 11:30:00', 3000, 'TUNAI', 8),
('2026-11-05 08:00:00', 12000, 'TRANSFER', 9),
('2026-11-05 10:00:00', 10000, 'EDC', 10);

SELECT * FROM transaksi;
SELECT * FROM transaksi_detail;
SELECT * FROM pembayaran;