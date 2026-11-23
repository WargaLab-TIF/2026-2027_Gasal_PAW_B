# PAW Modul 6 – Pengelolaan Master Detail Data

## Struktur File

```
paw_modul6/
├── database.sql      # Script SQL lengkap (tabel + relasi + data sample)
├── koneksi.php       # Koneksi database
├── index.php         # Dashboard
├── transaksi.php     # Halaman Master-Detail Transaksi (tugas 2 & 4)
├── barang.php        # Kelola Barang + fitur hapus dengan pengecekan (tugas 3)
└── README.md
```

## Cara Menjalankan

1. **Import Database**
   ```bash
   mysql -u root -p < database.sql
   ```
   atau via phpMyAdmin: buat database `paw_modul6` lalu import file `database.sql`.

2. **Sesuaikan koneksi** di `koneksi.php` jika username/password MySQL berbeda.

3. **Jalankan di web server** (XAMPP/Laragon/dll):
   - Letakkan folder di `htdocs` atau `www`
   - Akses: `http://localhost/paw_modul6/`

## Pemenuhan Tugas Praktikum

### 1. Database sesuai diagram
- Semua tabel dibuat: `supplier`, `barang`, `pelanggan`, `transaksi`, `transaksi_detail`, `pembayaran`, `user`
- Foreign key terpasang dengan constraint yang sesuai
- Data sample:
  - Supplier: 5
  - Barang: 10
  - Pelanggan: 5
  - Transaksi: 12 (≥10)
  - Detail: 22 data
  - Pembayaran: 5
  - User: 3

### 2. Halaman Master-Detail Transaksi
- **Master**: daftar transaksi (klik baris untuk pilih)
- **Detail**: item transaksi yang dipilih
- Form input detail:
  - Dropdown barang diambil dari tabel `barang`
  - Barang yang sudah masuk ke detail transaksi tersebut **disabled** (tidak bisa dipilih lagi)
  - Ada unique constraint `UNIQUE(transaksi_id, barang_id)` di database sebagai perlindungan tambahan

### 3. Fitur Hapus Barang dengan Pengecekan
- Sebelum hapus, sistem cek apakah `barang_id` sudah ada di `transaksi_detail`
- Jika sudah dipakai → tampil notifikasi & tombol hapus disabled
- Jika belum dipakai → boleh dihapus

### 4. Auto-update Total Transaksi
- Setiap kali detail baru disimpan (atau dihapus), sistem menghitung ulang:
  ```sql
  SUM(harga * qty) dari seluruh detail milik transaksi yang sama
  ```
- Hasilnya disimpan ke kolom `total` pada tabel `transaksi`

## Catatan Teknis
- Menggunakan Bootstrap 5 + Bootstrap Icons
- Relasi ON DELETE:
  - `transaksi_detail` → CASCADE (hapus transaksi ikut hapus detail)
  - `barang` di detail → RESTRICT (tidak bisa hapus barang yang masih dipakai)
  - `pelanggan` di transaksi → RESTRICT
