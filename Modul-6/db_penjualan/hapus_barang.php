<?php
include 'koneksi.php';

$id = $_GET['id'];

// Cek apakah barang sudah digunakan dalam transaksi
$cek = mysqli_query($koneksi, "
    SELECT * FROM transaksi_detail
    WHERE barang_id = '$id'
");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
        alert('Barang tidak bisa dihapus karena sudah digunakan dalam transaksi!');
        window.location='barang.php';
    </script>";
} else {

    mysqli_query($koneksi, "
        DELETE FROM barang
        WHERE id = '$id'
    ");

    echo "<script>
        alert('Barang berhasil dihapus!');
        window.location='barang.php';
    </script>";
}
?>