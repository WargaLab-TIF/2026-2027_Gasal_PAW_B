
<?php
include 'koneksi.php';

// Mengecek apakah data barang sudah ada
$cek = mysqli_query($conn, "SELECT * FROM barang");

if (mysqli_num_rows($cek) == 0) {

    $sql = "INSERT INTO barang
    (kode_barang, nama_barang, harga, stok, supplier_id)
    VALUES
    ('BRG001', 'Laptop Asus', 7500000, 10, 1),
    ('BRG002', 'Mouse Logitech', 150000, 25, 2),
    ('BRG003', 'Keyboard Mechanical', 350000, 15, 3),
    ('BRG004', 'Monitor LG', 1800000, 8, 4),
    ('BRG005', 'Flashdisk Sandisk', 85000, 30, 5)";

    if (mysqli_query($conn, $sql)) {
        echo "5 data barang berhasil ditambahkan!";
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }

} else {
    echo "Data barang sudah tersedia.";
}
?>
