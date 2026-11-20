<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

if (isset($_GET['id'])) {
    hapus_user($_GET['id']);
}

header("Location: user.php");
exit();
?>
