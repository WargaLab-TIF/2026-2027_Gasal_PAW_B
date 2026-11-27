<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

if (isset($_GET["id"])) {
    if (hapusBarang($_GET["id"])) {
        echo "<script>alert('Barang berhasil dihapus'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Barang tidak dapat dihapus karena masih dipakai di data lain'); window.location='index.php';</script>";
    }
    exit();
}

header("Location: index.php");
exit();
?>
