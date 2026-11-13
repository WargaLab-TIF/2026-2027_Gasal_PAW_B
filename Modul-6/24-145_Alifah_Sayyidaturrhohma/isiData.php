<?php
include 'koneksi.php';

// Mengecek jumlah data supplier
$cek = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM supplier");
$data = mysqli_fetch_assoc($cek);
if ($data['jumlah'] == 0) {
    // Memasukkan 5 data supplier
    $sql = "INSERT INTO supplier (nama, telp, alamat) VALUES
    ('PT Sumber Makmur', '081234567801', 'Surabaya'),
    ('CV Berkah Jaya', '081234567802', 'Bangkalan'),
    ('UD Maju Bersama', '081234567803', 'Madura'),
    ('PT Indo Sejahtera', '081234567804', 'Sidoarjo'),
    ('CV Mitra Niaga', '081234567805', 'Gresik')";

    if (mysqli_query($conn, $sql)) {
        echo " 5 data supplier berhasil ditambahkan!";
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }

} else {
    echo "Data supplier sudah tersedia, tidak perlu ditambahkan lagi.";
}
?>
