<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

if (isset($_GET['id'])) {
    $berhasil = hapus_pelanggan($_GET['id']);
    if (!$berhasil) {
        header("Location: pelanggan.php?status=gagal_hapus");
        exit();
    }
}

header("Location: pelanggan.php?status=sukses_hapus");
exit();
?>
