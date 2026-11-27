<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

if (isset($_GET["id"])) {
    hapusUser($_GET["id"]);
    echo "<script>alert('User berhasil dihapus'); window.location='index.php';</script>";
    exit();
}

header("Location: index.php");
exit();
?>
