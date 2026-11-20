<?php
include 'koneksi.php';

if (isset($_POST['hapus'])) {

    $id = (int) $_POST['id'];

    $cek = mysqli_prepare($conn, "
        SELECT COUNT(*) AS jumlah
        FROM transaksi_detail
        WHERE barang_id = ?
    ");

    mysqli_stmt_bind_param($cek, "i", $id);
    mysqli_stmt_execute($cek);

    $hasil = mysqli_stmt_get_result($cek);
    $data = mysqli_fetch_assoc($hasil);

    if ($data['jumlah'] > 0) {

        echo "<script>
            alert('Barang tidak dapat dihapus karena masih digunakan dalam transaksi!');
            window.location='barang.php';
        </script>";

    } else {

        $hapus = mysqli_prepare($conn, "
            DELETE FROM barang WHERE id = ?
        ");

        mysqli_stmt_bind_param($hapus, "i", $id);

        if (mysqli_stmt_execute($hapus)) {

            echo "<script>
                alert('Data barang berhasil dihapus!');
                window.location='barang.php';
            </script>";

        } else {

            echo "<script>
                alert('Data barang gagal dihapus!');
                window.location='barang.php';
            </script>";

        }
    }

} else {
    header("Location: barang.php");
    exit;
}
?>