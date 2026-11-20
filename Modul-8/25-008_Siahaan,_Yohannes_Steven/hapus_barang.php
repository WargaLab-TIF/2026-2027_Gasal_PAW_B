<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

if (isset($_GET['id'])) {
    $berhasil = hapus_barang($_GET['id']);
    if (!$berhasil) {
        header("Location: barang.php?status=gagal_hapus");
        exit();
    }
}

header("Location: barang.php?status=sukses_hapus");
exit();
?>
