<?php
require_once 'config.php';
wajib_login();   // proteksi: harus login sebelum bisa export

define('EXPORT', true);
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment;filename=rekap_penjualan.xls");

include "laporan.php";
