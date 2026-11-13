-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2026 at 06:53 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int NOT NULL,
  `stok` int NOT NULL,
  `supplier_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG001', 'Beras 5kg', 65000, 100, 1),
(2, 'BRG002', 'Minyak Goreng 2L', 38000, 80, 1),
(3, 'BRG003', 'Gula Pasir 1kg', 16000, 120, 2),
(4, 'BRG004', 'Kopi Bubuk 200g', 22000, 60, 2),
(5, 'BRG005', 'Teh Celup 25s', 9000, 90, 3),
(6, 'BRG006', 'Susu UHT 1L', 18000, 70, 3),
(7, 'BRG007', 'Mi Instan', 3500, 200, 4),
(8, 'BRG008', 'Sabun Mandi', 4500, 150, 5),
(9, 'BRG009', 'Barang Uji Hapus', 10000, 10, 5);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
('PLG001', 'Budi Santoso', 'L', '081234500001', 'Bangkalan'),
('PLG002', 'Siti Aminah', 'P', '081234500002', 'Sampang'),
('PLG003', 'Ahmad Fauzi', 'L', '081234500003', 'Pamekasan'),
('PLG004', 'Dewi Lestari', 'P', '081234500004', 'Sumenep'),
('PLG005', 'Rina Wulandari', 'P', '081234500005', 'Surabaya');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int NOT NULL,
  `waktu_bayar` datetime NOT NULL,
  `total` int NOT NULL,
  `metode` enum('TUNAI','TRANSFER','EDC') NOT NULL,
  `transaksi_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
(1, '2026-10-01 10:00:00', 146000, 'TUNAI', 1),
(2, '2026-10-03 10:00:00', 73000, 'TUNAI', 2),
(3, '2026-10-05 10:00:00', 89000, 'TUNAI', 3),
(4, '2026-10-08 10:00:00', 22500, 'TUNAI', 4),
(5, '2026-10-10 10:00:00', 141000, 'TUNAI', 5),
(8, '2026-10-12 14:00:00', 65500, 'TRANSFER', 6),
(9, '2026-10-15 14:00:00', 72000, 'TRANSFER', 7),
(10, '2026-10-18 14:00:00', 49000, 'TRANSFER', 8),
(11, '2026-10-20 16:00:00', 195000, 'EDC', 9),
(12, '2026-10-25 16:00:00', 84000, 'EDC', 10);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT Sumber Pangan', '031555101', 'Jl. Raya Surabaya No. 10'),
(2, 'CV Maju Jaya', '031555102', 'Jl. Pahlawan No. 22'),
(3, 'UD Berkah Abadi', '031555103', 'Jl. Merdeka No. 5'),
(4, 'PT Indo Mie', '031555104', 'Jl. Industri No. 8'),
(5, 'CV Bersih Sejahtera', '031555105', 'Jl. Diponegoro No. 15');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `waktu_transaksi` date NOT NULL,
  `keterangan` text,
  `total` int NOT NULL DEFAULT '0',
  `pelanggan_id` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-10-01', 'Belanja bulanan', 146000, 'PLG001'),
(2, '2026-10-03', 'Pembelian harian', 73000, 'PLG002'),
(3, '2026-10-05', 'Kebutuhan kantor', 89000, 'PLG003'),
(4, '2026-10-08', 'Pembelian sabun', 22500, 'PLG004'),
(5, '2026-10-10', 'Belanja mingguan', 141000, 'PLG005'),
(6, '2026-10-12', 'Pembelian dapur', 65500, 'PLG001'),
(7, '2026-10-15', 'Pembelian susu', 72000, 'PLG002'),
(8, '2026-10-18', 'Belanja campur', 49000, 'PLG003'),
(9, '2026-10-20', 'Pembelian beras', 195000, 'PLG004'),
(10, '2026-10-25', 'Belanja akhir bulan', 84000, 'PLG005'),
(11, '2026-11-06', 'belanja', 54000, 'PLG002');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int NOT NULL,
  `barang_id` int NOT NULL,
  `harga` int NOT NULL,
  `qty` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 65000, 2),
(1, 3, 16000, 1),
(2, 2, 38000, 1),
(2, 7, 3500, 10),
(3, 4, 22000, 2),
(3, 5, 9000, 3),
(3, 6, 18000, 1),
(4, 8, 4500, 5),
(5, 1, 65000, 1),
(5, 2, 38000, 2),
(6, 3, 16000, 3),
(6, 7, 3500, 5),
(7, 6, 18000, 4),
(8, 4, 22000, 1),
(8, 5, 9000, 2),
(8, 8, 4500, 2),
(9, 1, 65000, 3),
(10, 2, 38000, 1),
(10, 3, 16000, 2),
(10, 7, 3500, 4),
(11, 8, 4500, 12);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` tinyint NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `level` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator', 'Bangkalan', '081200000001', 1),
(2, 'kasir', 'de28f8f7998f23ab4194b51a6029416f', 'Kasir Toko', 'Bangkalan', '081200000002', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelanggan_id` (`pelanggan_id`);

--
-- Indexes for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD PRIMARY KEY (`transaksi_id`,`barang_id`),
  ADD KEY `barang_id` (`barang_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`);

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`);

--
-- Constraints for table `transaksi_detail`
--
ALTER TABLE `transaksi_detail`
  ADD CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`),
  ADD CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
