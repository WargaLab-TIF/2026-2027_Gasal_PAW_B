<?php
include 'koneksi.php';

$id = (int) $_GET['id'];

$cek = mysqli_query($conn, "
    SELECT * FROM transaksi_detail
    WHERE barang_id = $id
");

if (mysqli_num_rows($cek) > 0) {

    echo "<script>
        alert('Barang masih digunakan pada transaksi!');
        window.location='barang.php';
    </script>";

} else {

    mysqli_query($conn, "
        DELETE FROM barang WHERE id = $id
    ");

    echo "<script>
        alert('Barang berhasil dihapus!');
        window.location='barang.php';
    </script>";
}
?>