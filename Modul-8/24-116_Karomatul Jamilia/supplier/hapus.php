<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

if (isset($_GET["id"])) {
    if (hapusSupplier($_GET["id"])) {
        echo "<script>alert('Supplier berhasil dihapus'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Supplier tidak dapat dihapus karena masih dipakai di data lain'); window.location='index.php';</script>";
    }
    exit();
}

header("Location: index.php");
exit();
?>
