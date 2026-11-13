<?php
include "koneksi.php";

$cek = mysqli_query($conn, "SELECT * FROM transaksi");

if (mysqli_num_rows($cek) == 0) {
    $query = mysqli_query($conn, "INSERT INTO transaksi
    (waktu_transaksi, keterangan, total, pelanggan_id) VALUES
    ('2026-11-01', 'Pembelian barang 1', 0, 'PLG001'),
    ('2026-11-02', 'Pembelian barang 2', 0, 'PLG002'),
    ('2026-11-03', 'Pembelian barang 3', 0, 'PLG003'),
    ('2026-11-04', 'Pembelian barang 4', 0, 'PLG004'),
    ('2026-11-05', 'Pembelian barang 5', 0, 'PLG005'),
    ('2026-11-06', 'Pembelian barang 6', 0, 'PLG001'),
    ('2026-11-07', 'Pembelian barang 7', 0, 'PLG002'),
    ('2026-11-08', 'Pembelian barang 8', 0, 'PLG003'),
    ('2026-11-09', 'Pembelian barang 9', 0, 'PLG004'),
    ('2026-11-10', 'Pembelian barang 10', 0, 'PLG005')");

    if ($query) {
        echo "10 data transaksi berhasil ditambahkan.";
    } else {
        echo "Data transaksi gagal ditambahkan: " . mysqli_error($conn);
    }
} else {
    echo "Tabel transaksi sudah memiliki data.";
}
?>
