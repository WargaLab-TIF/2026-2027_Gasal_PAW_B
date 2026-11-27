<?php 
require "fungsi.php";
include "midlewire.php";

if (isset($_GET['id_buku'])) {
    hapus_buku($_GET['id_buku']);
}

header("Location: index.php");
exit();
?>
