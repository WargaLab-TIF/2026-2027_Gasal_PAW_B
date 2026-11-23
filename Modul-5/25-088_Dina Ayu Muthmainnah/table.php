<?php
include 'koneksi.php';

// Membuat tabel supplier
$query = "CREATE TABLE IF NOT EXISTS supplier (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    telp VARCHAR(20) NOT NULL,
    alamat VARCHAR(255) NOT NULL
)";

mysqli_query($conn, $query);

// Mengecek apakah tabel masih kosong
$cek = mysqli_query($conn, "SELECT * FROM supplier");

if (mysqli_num_rows($cek) == 0) {

    // Memasukkan data supplier
    $query = "INSERT INTO supplier (nama, telp, alamat) VALUES
    ('PT. Maju Bersama', '08123456', 'Surabaya'),
    ('PT. Senang Sekali', '081515563', 'Bangkalan'),
    ('PT. Segar Segar', '0845454663', 'Surabaya')";

    mysqli_query($conn, $query);

    echo "Tabel dan data supplier berhasil dibuat!";
} else {
    echo "Tabel supplier sudah memiliki data!";
}
?>