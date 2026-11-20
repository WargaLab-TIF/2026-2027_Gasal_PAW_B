<?php
ob_start();

include "laporan.php";

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

ob_end_flush();
?>
