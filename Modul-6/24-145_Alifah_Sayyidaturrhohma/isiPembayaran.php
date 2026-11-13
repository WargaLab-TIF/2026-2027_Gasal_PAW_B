<?php
include "koneksi.php";

$cek = mysqli_query($conn, "SELECT * FROM pembayaran");

if (mysqli_num_rows($cek) == 0) {
    $query = mysqli_query($conn, "INSERT INTO pembayaran
    (waktu_bayar, total, metode, transaksi_id) VALUES
    ('2026-11-01 10:00:00', 153000, 'TUNAI', 1),
    ('2026-11-02 11:00:00', 500000, 'TRANSFER', 2),
    ('2026-11-03 12:00:00', 2500000, 'EDC', 3),
    ('2026-11-04 13:00:00', 2055000, 'TUNAI', 4),
    ('2026-11-05 14:00:00', 7670000, 'TRANSFER', 5),
    ('2026-11-06 15:00:00', 650000, 'EDC', 6),
    ('2026-11-07 16:00:00', 520000, 'TUNAI', 7),
    ('2026-11-08 17:00:00', 1950000, 'TRANSFER', 8),
    ('2026-11-09 18:00:00', 7850000, 'EDC', 9),
    ('2026-11-10 19:00:00', 640000, 'TUNAI', 10)");

    if ($query) {
        echo "Data pembayaran berhasil ditambahkan.";
    } else {
        echo "Data pembayaran gagal ditambahkan: " . mysqli_error($conn);
    }
} else {
    echo "Tabel pembayaran sudah memiliki data.";
}
?>
