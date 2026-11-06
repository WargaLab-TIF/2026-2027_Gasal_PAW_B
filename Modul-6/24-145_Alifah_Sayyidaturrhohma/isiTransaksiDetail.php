<?php
include "koneksi.php";

$cek = mysqli_query($conn, "SELECT * FROM transaksi_detail");

if (mysqli_num_rows($cek) == 0) {
    $query = mysqli_query($conn, "INSERT INTO transaksi_detail
    (transaksi_id, barang_id, harga, qty) VALUES
    (1, 1, 7500000, 1),
    (1, 2, 150000, 2),
    (2, 2, 150000, 1),
    (2, 3, 350000, 1),
    (3, 3, 350000, 2),
    (3, 4, 1800000, 1),
    (4, 4, 1800000, 1),
    (4, 5, 85000, 3),
    (5, 1, 7500000, 1),
    (5, 5, 85000, 2),
    (6, 2, 150000, 2),
    (6, 3, 350000, 1),
    (7, 3, 350000, 1),
    (7, 5, 85000, 2),
    (8, 4, 1800000, 1),
    (8, 2, 150000, 1),
    (9, 1, 7500000, 1),
    (9, 3, 350000, 1),
    (10, 5, 85000, 4),
    (10, 2, 150000, 2)");

    if ($query) {
        echo "Data transaksi detail berhasil ditambahkan.";
    } else {
        echo "Data transaksi detail gagal ditambahkan: " . mysqli_error($conn);
    }
} else {
    echo "Tabel transaksi_detail sudah memiliki data.";
}
?>
