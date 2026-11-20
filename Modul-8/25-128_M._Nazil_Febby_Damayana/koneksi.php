<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);

$conn = mysqli_connect('localhost', 'root', '', 'penjualan');
if (!$conn) {
    die('Koneksi database gagal');
}

function esc($s)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($s));
}

function h($s)
{
    return htmlspecialchars($s ?? '');
}

function rp($n)
{
    return 'Rp ' . number_format($n, 0, ',', '.');
}
