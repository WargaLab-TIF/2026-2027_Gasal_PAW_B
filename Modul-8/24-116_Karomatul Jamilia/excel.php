<?php
// Header harus dikirim SEBELUM ada output apapun
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

$mode_excel = true;     // supaya navbar tidak ikut masuk ke file Excel
require "laporan.php";  // laporan.php sudah memanggil midlewire.php (wajib login)
?>
