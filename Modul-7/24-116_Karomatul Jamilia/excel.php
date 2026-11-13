<?php
    require "laporan.php";
    // Header mengunduh file berformat Excel (.xls)
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

?>