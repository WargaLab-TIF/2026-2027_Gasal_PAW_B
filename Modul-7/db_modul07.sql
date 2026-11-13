CREATE DATABASE IF NOT  EXITS db_modul07;
  USE db_modul07;

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `supplier_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'C001', 'Chitato Sapi Panggang', 12000, 50, 1),
(2, 'C002', 'Qtela Singkong Balado', 10000, 40, 2),
(3, 'C003', 'Oreo Original', 9000, 60, 3),
(4, 'C004', 'Beng-Beng Cokelat', 3000, 100, 3),
(5, 'C005', 'Kusuka Original', 11000, 45, 4),
(6, 'C006', 'Taro Net Seaweed', 8000, 55, 5),
(7, 'C007', 'Pocky Cokelat', 10000, 35, 1),
(8, 'C008', 'Roma Kelapa', 7500, 50, 2),
(9, 'C009', 'SilverQueen Mini', 15000, 30, 5),
(10, 'C010', 'Makaroni Pedas', 5000, 80, 4);

CREATE TABLE `pelanggan` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
('P001', 'min yoongi', 'L', '081111111111', 'Surabaya'),
('P002', 'Lalisa', 'P', '082222222222', 'Sidoarjo'),
('P003', 'jeon jungkook', 'L', '083333333333', 'Gresik'),
('P004', 'kim jennie', 'P', '084444444444', 'Malang'),
('P005', 'kim taehyung', 'L', '085555555555', 'Surabaya');

CREATE TABLE `pembayaran` (
  `id` int NOT NULL,
  `waktu_bayar` datetime NOT NULL,
  `total` int NOT NULL,
  `metode` enum('TUNAI','TRANSFER','EDC') NOT NULL,
  `transaksi_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-10-01 10:00:00', 33000, 'TUNAI', 1),
(2, '2026-10-02 10:00:00', 29000, 'TRANSFER', 2),
(3, '2026-10-03 10:00:00', 27000, 'EDC', 3),
(4, '2026-10-04 10:00:00', 35000, 'TUNAI', 4),
(5, '2026-10-05 10:00:00', 30000, 'TRANSFER', 5),
(6, '2026-10-06 10:00:00', 32000, 'EDC', 6),
(7, '2026-10-07 10:00:00', 33000, 'TUNAI', 7),
(8, '2026-10-08 10:00:00', 32000, 'TRANSFER', 8),
(9, '2026-10-09 10:00:00', 34000, 'EDC', 9);

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT Sumber Snack', '081234567801', 'Surabaya'),
(2, 'CV Maju Jaya', '081234567802', 'Sidoarjo'),
(3, 'PT Indofood', '081234567803', 'Jakarta'),
(4, 'CV Cemilan Makmur', '081234567804', 'Gresik'),
(5, 'PT Aneka Rasa', '081234567805', 'Malang');

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `waktu_transaksi` date NOT NULL,
  `keterangan` text,
  `total` int NOT NULL DEFAULT '0',
  `pelanggan_id` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-10-01', 'Pembelian cemilan', 33000, 'P001'),
(2, '2026-10-02', 'Pembelian snack', 29000, 'P002'),
(3, '2026-10-03', 'Pembelian harian', 27000, 'P003'),
(4, '2026-10-04', 'Pembelian cemilan', 35000, 'P004'),
(5, '2026-10-05', 'Pembelian snack', 30000, 'P005'),
(6, '2026-10-06', 'Pembelian harian', 32000, 'P001'),
(7, '2026-10-07', 'Pembelian cemilan', 33000, 'P002'),
(8, '2026-10-08', 'Pembelian snack', 32000, 'P003'),
(9, '2026-10-09', 'Pembelian harian', 34000, 'P004'),
(12, '2026-11-06', 'pembelian jajan', 86000, 'P001');

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int NOT NULL,
  `barang_id` int NOT NULL,
  `harga` int NOT NULL,
  `qty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 12000, 2),
(1, 4, 3000, 3),
(2, 2, 10000, 2),
(2, 3, 9000, 1),
(3, 5, 11000, 1),
(3, 6, 8000, 2),
(4, 7, 10000, 2),
(4, 8, 7500, 2),
(5, 9, 15000, 1),
(5, 10, 5000, 3),
(6, 1, 12000, 1),
(6, 2, 10000, 2),
(7, 3, 9000, 2),
(7, 4, 3000, 5),
(8, 5, 11000, 2),
(8, 7, 10000, 1),
(9, 6, 8000, 3),
(9, 10, 5000, 2),
(12, 1, 12000, 4),
(12, 2, 10000, 2),
(12, 3, 9000, 2);