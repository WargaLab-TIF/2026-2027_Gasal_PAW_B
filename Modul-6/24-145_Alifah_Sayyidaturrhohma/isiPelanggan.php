<?php
include "koneksi.php";

$cek = mysqli_query($conn, "SELECT * FROM pelanggan");

if (mysqli_num_rows($cek) == 0) {
    $query = mysqli_query($conn, "INSERT INTO pelanggan
    (id, nama, jenis_kelamin, telp, alamat) VALUES
    ('PLG001', 'Andi Saputra', 'L', '081234567811', 'Bangkalan'),
    ('PLG002', 'Siti Aminah', 'P', '081234567812', 'Surabaya'),
    ('PLG003', 'Budi Santoso', 'L', '081234567813', 'Sampang'),
    ('PLG004', 'Dewi Lestari', 'P', '081234567814', 'Pamekasan'),
    ('PLG005', 'Rizky Pratama', 'L', '081234567815', 'Sidoarjo')");

    if ($query) {
        echo "Data pelanggan berhasil ditambahkan.";
    } else {
        echo "Data pelanggan gagal ditambahkan: " . mysqli_error($conn);
    }
} else {
    echo "Tabel pelanggan sudah memiliki data.";
}
?>
