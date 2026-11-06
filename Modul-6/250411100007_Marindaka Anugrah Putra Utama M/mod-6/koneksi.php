<?php
$koneksi = mysqli_connect("localhost", "root", "", "penjualan");
if (mysqli_connect_error()) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
function h($s) { return htmlspecialchars((string)$s); }