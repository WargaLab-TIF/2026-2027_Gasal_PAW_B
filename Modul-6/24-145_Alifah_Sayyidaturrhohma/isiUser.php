<?php
include "koneksi.php";

$cek = mysqli_query($conn, "SELECT * FROM user");

if (mysqli_num_rows($cek) == 0) {
    $query = mysqli_query($conn, "INSERT INTO user
    (id_user, username, password, nama, alamat, hp, level) VALUES
    (1, 'admin', 'admin123', 'Administrator', 'Bangkalan', '081234567821', 1),
    (2, 'andi', 'andi123', 'Andi Saputra', 'Surabaya', '081234567822', 2),
    (3, 'siti', 'siti123', 'Siti Aminah', 'Sampang', '081234567823', 2),
    (4, 'budi', 'budi123', 'Budi Santoso', 'Pamekasan', '081234567824', 2),
    (5, 'dewi', 'dewi123', 'Dewi Lestari', 'Sidoarjo', '081234567825', 2)");

    if ($query) {
        echo "Data user berhasil ditambahkan.";
    } else {
        echo "Data user gagal ditambahkan: " . mysqli_error($conn);
    }
} else {
    echo "Tabel user sudah memiliki data.";
}
?>
