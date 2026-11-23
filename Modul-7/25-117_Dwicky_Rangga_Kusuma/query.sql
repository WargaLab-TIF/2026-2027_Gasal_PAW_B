-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for penjualan
CREATE DATABASE IF NOT EXISTS `penjualan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `penjualan`;

-- Dumping structure for table penjualan.barang
CREATE TABLE IF NOT EXISTS `barang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(10) DEFAULT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table penjualan.barang: ~8 rows (approximately)
INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
	(1, 'BRG001', 'Beras 5 Kg', 65000, 50, 1),
	(2, 'BRG002', 'Minyak Goreng 2 L', 38000, 40, 1),
	(3, 'BRG003', 'Gula Pasir 1 Kg', 16000, 60, 2),
	(4, 'BRG004', 'Telur Ayam 1 Kg', 28000, 30, 2),
	(5, 'BRG005', 'Kopi Bubuk 200 g', 22000, 45, 3),
	(6, 'BRG006', 'Teh Celup 25 pcs', 9000, 80, 3),
	(7, 'BRG007', 'Sabun Mandi', 6000, 100, 4),
	(8, 'BRG008', 'Deterjen 800 g', 21000, 35, 5);

-- Dumping structure for table penjualan.pelanggan
CREATE TABLE IF NOT EXISTS `pelanggan` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table penjualan.pelanggan: ~5 rows (approximately)
INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
	('PLG001', 'Ahmad Fauzi', 'L', '081234560001', 'Bangkalan'),
	('PLG002', 'Siti Aisyah', 'P', '081234560002', 'Sampang'),
	('PLG003', 'Budi Santoso', 'L', '081234560003', 'Pamekasan'),
	('PLG004', 'Dewi Lestari', 'P', '081234560004', 'Sumenep'),
	('PLG005', 'Rina Marlina', 'P', '081234560005', 'Surabaya');

-- Dumping structure for table penjualan.pembayaran
CREATE TABLE IF NOT EXISTS `pembayaran` (
  `id` int NOT NULL AUTO_INCREMENT,
  `waktu_bayar` datetime DEFAULT NULL,
  `total` int DEFAULT NULL,
  `metode` enum('TUNAI','TRANSFER','EDC') DEFAULT NULL,
  `transaksi_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transaksi_id` (`transaksi_id`),
  CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table penjualan.pembayaran: ~5 rows (approximately)
INSERT INTO `pembayaran` (`id`, `waktu_bayar`, `total`, `metode`, `transaksi_id`) VALUES
	(1, '2026-10-01 10:00:00', 146000, 'TUNAI', 1),
	(2, '2026-10-03 11:30:00', 94000, 'TRANSFER', 2),
	(3, '2026-10-05 09:15:00', 66000, 'TUNAI', 3),
	(4, '2026-10-08 14:20:00', 186000, 'EDC', 4),
	(5, '2026-10-10 16:45:00', 92000, 'TUNAI', 5);

-- Dumping structure for table penjualan.supplier
CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table penjualan.supplier: ~5 rows (approximately)
INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
	(1, 'PT Sumber Pangan', '031555001', 'Surabaya'),
	(2, 'CV Maju Jaya', '031555002', 'Sidoarjo'),
	(3, 'UD Berkah Abadi', '031555003', 'Gresik'),
	(4, 'PT Bersih Sejahtera', '031555004', 'Malang'),
	(5, 'CV Sinar Makmur', '031555005', 'Bangkalan');

-- Dumping structure for table penjualan.transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `waktu_transaksi` date DEFAULT NULL,
  `keterangan` text,
  `total` int DEFAULT '0',
  `pelanggan_id` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pelanggan_id` (`pelanggan_id`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table penjualan.transaksi: ~10 rows (approximately)
INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
	(1, '2026-10-01', 'Belanja bulanan', 146000, 'PLG001'),
	(2, '2026-10-03', 'Belanja harian', 94000, 'PLG002'),
	(3, '2026-10-05', 'Beli kopi', 66000, 'PLG003'),
	(4, '2026-10-08', 'Belanja mingguan', 186000, 'PLG004'),
	(5, '2026-10-10', 'Belanja harian', 92000, 'PLG005'),
	(6, '2026-10-12', 'Beli teh', 90000, 'PLG001'),
	(7, '2026-10-15', 'Belanja harian', 76000, 'PLG002'),
	(8, '2026-10-18', 'Beli beras', 195000, 'PLG003'),
	(9, '2026-10-20', 'Belanja harian', 98000, 'PLG004'),
	(10, '2026-10-22', 'Belanja mingguan', 120000, 'PLG005');

-- Dumping structure for table penjualan.transaksi_detail
CREATE TABLE IF NOT EXISTS `transaksi_detail` (
  `transaksi_id` int NOT NULL,
  `barang_id` int NOT NULL,
  `harga` int DEFAULT NULL,
  `qty` int DEFAULT NULL,
  PRIMARY KEY (`transaksi_id`,`barang_id`),
  KEY `barang_id` (`barang_id`),
  CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table penjualan.transaksi_detail: ~18 rows (approximately)
INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
	(1, 1, 65000, 2),
	(1, 3, 16000, 1),
	(2, 2, 38000, 1),
	(2, 4, 28000, 2),
	(3, 5, 22000, 3),
	(4, 1, 65000, 1),
	(4, 2, 38000, 2),
	(4, 6, 9000, 5),
	(5, 3, 16000, 4),
	(5, 4, 28000, 1),
	(6, 6, 9000, 10),
	(7, 3, 16000, 2),
	(7, 5, 22000, 2),
	(8, 1, 65000, 3),
	(9, 2, 38000, 2),
	(9, 5, 22000, 1),
	(10, 4, 28000, 3),
	(10, 6, 9000, 4);

-- Dumping structure for table penjualan.user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` tinyint NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(35) DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(150) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL,
  `level` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table penjualan.user: ~2 rows (approximately)
INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `alamat`, `hp`, `level`) VALUES
	(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrator', 'Bangkalan', '081200000001', 1),
	(2, 'kasir', 'de28f8f7998f23ab4194b51a6029416f', 'Kasir Toko', 'Bangkalan', '081200000002', 2);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
