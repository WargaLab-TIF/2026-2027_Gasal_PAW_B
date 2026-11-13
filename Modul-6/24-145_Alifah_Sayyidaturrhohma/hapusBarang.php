<?php
include "koneksi.php";

$id = $_GET['id'];

$cek = mysqli_query($conn, "SELECT * FROM transaksi_detail WHERE barang_id = '$id'");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
        alert('Data barang tidak boleh dihapus karena masih digunakan pada transaksi!');
        window.location.href = 'barang.php';
    </script>";
} else {
    $hapus = mysqli_query($conn, "DELETE FROM barang WHERE id = '$id'");

    if ($hapus) {
        echo "<script>
            alert('Data barang berhasil dihapus!');
            window.location.href = 'barang.php';
        </script>";
    } else {
        echo "Gagal menghapus barang: " . mysqli_error($conn);
    }
}
?>
