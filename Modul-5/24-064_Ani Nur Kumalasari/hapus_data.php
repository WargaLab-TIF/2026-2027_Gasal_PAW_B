<?php
include "koneksi.php";

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $query = mysqli_query($koneksi, "DELETE FROM master_suppiler WHERE id=$id");

    if ($query) {
        header("Location: data_baru.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    header("Location: data_baru.php");
    exit;
}
?>
