# Data Master Supplier - Tugas Praktikum Modul 5 (Database)

Aplikasi CRUD sederhana menggunakan PHP + MySQL (mysqli) sesuai materi Modul 5 dan Tugas Praktikum.

## Struktur File

```
supplier_crud/
├── koneksi.php     → Koneksi ke database
├── setup.php       → Script sekali jalan untuk buat DB + tabel + data sample
├── index.php       → Halaman utama (tampil data + tombol Edit/Hapus)
├── tambah.php      → Halaman tambah data baru
├── edit.php        → Halaman edit data
├── hapus.php       → Proses hapus data
└── README.md
```

## Cara Menjalankan

1. Pastikan XAMPP / Laragon / WAMP sudah running (Apache + MySQL).
2. Copy folder `supplier_crud` ke dalam folder `htdocs` (XAMPP) atau `www`.
3. Buka browser → `http://localhost/supplier_crud/setup.php`  
   (jalankan sekali saja untuk membuat database `db_supplier`, tabel, dan data sample).
4. Setelah setup berhasil, buka `http://localhost/supplier_crud/index.php`.

## Fitur sesuai Tugas Praktikum

1. **Tampilan & Ambil Data**  
   Menampilkan tabel Data Master Supplier (No, Nama, Telp, Alamat, Tindakan).

2. **Tambah Data**  
   Tombol hijau **Tambah Data** → form input Nama, Telp, Alamat → Simpan / Batal.

3. **Edit Data**  
   Tombol **Edit** (oranye) → form terisi data lama → Update / Batal.

4. **Hapus Data + Popup Konfirmasi**  
   Tombol **Hapus** memunculkan popup browser:  
   `"Anda yakin akan menghapus supplier ini?"`  
   (OK / Cancel). Jika OK, data dihapus.

## Catatan

- Username MySQL default: `root`, password kosong (sesuaikan di `koneksi.php` jika berbeda).
- Kode mengikuti gaya modul (mysqli_connect, mysqli_query, dll).
- Data sample sesuai gambar di tp.pdf:
  - PT. Maju Bersama | 08123456 | Surabaya
  - PT. Bintang Sakti | 081515563 | Bangkalan
  - PT. Segar Segar | 0845454663 | Surabaya
