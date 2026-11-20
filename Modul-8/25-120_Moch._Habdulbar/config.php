<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect('localhost', 'root', '', 'penjualan');
mysqli_set_charset($conn, 'utf8mb4');

function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function rp($n) { return 'Rp ' . number_format($n, 0, ',', '.'); }
function flash($m) { $_SESSION['flash'] = $m; }

// Proteksi halaman: belum login -> ke login
function wajib_login() {
    if (!isset($_SESSION['id_user'])) { header('Location: login.php'); exit; }
}
// Proteksi berdasarkan level (dipakai untuk halaman Data Master = level 1)
function wajib_level($level) {
    wajib_login();
    if ($_SESSION['level'] != $level) { header('Location: index.php'); exit; }
}
