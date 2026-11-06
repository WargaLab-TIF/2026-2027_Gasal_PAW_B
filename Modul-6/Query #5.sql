INSERT INTO supplier (nama, telp, alamat) VALUES
('PT Sumber Makmur', '081234567801', 'Surabaya'),
('CV Jaya Abadi', '081234567802', 'Madura'),
('PT Berkah Jaya', '081234567803', 'Sidoarjo'),
('CV Mitra Usaha', '081234567804', 'Gresik'),
('PT Maju Bersama', '081234567805', 'Bangkalan');

INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES
('BRG001', 'Buku Tulis', 5000, 100, 1),
('BRG002', 'Pulpen', 3000, 150, 2),
('BRG003', 'Pensil', 2000, 120, 3),
('BRG004', 'Penghapus', 1500, 80, 4),
('BRG005', 'Penggaris', 4000, 90, 5);

INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES
('PLG001', 'Andi', 'L', '081111111111', 'Surabaya'),
('PLG002', 'Budi', 'L', '082222222222', 'Madura'),
('PLG003', 'Citra', 'P', '083333333333', 'Bangkalan'),
('PLG004', 'Dina', 'P', '084444444444', 'Sidoarjo'),
('PLG005', 'Eka', 'P', '085555555555', 'Gresik');

INSERT INTO `user` (username, password, nama, alamat, hp, level) VALUES
('admin', 'admin123', 'Administrator', 'Surabaya', '081234567890', 1),
('kasir1', 'kasir123', 'Kasir Satu', 'Madura', '081234567891', 2),
('kasir2', 'kasir123', 'Kasir Dua', 'Bangkalan', '081234567892', 2),
('kasir3', 'kasir123', 'Kasir Tiga', 'Gresik', '081234567893', 2),
('kasir4', 'kasir123', 'Kasir Empat', 'Sidoarjo', '081234567894', 2);

SELECT * FROM supplier;
SELECT * FROM barang;
SELECT * FROM pelanggan;
SELECT * FROM `user`;