<?php
include "koneksi.php";

$id = (int) $_POST['id'];

$query_cek = mysqli_query($conn, "
    SELECT * FROM transaksi_detail
    WHERE barang_id = $id
");

if (mysqli_num_rows($query_cek) > 0) {

    header("Location: barang.php?error=1&status=Barang masih digunakan dalam transaksi");

} else {

    $query_hapus = mysqli_query($conn, "
        DELETE FROM barang WHERE id = $id
    ");

    if ($query_hapus) {
        header("Location: barang.php?status=Barang berhasil dihapus");
    } else {
        header("Location: barang.php?error=1&status=Gagal menghapus barang");
    }
}

exit;
?>