<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

if (isset($_GET['id'])) {
    $berhasil = hapus_supplier($_GET['id']);
    if (!$berhasil) {
        header("Location: supplier.php?status=gagal_hapus");
        exit();
    }
}

header("Location: supplier.php?status=sukses_hapus");
exit();
?>
