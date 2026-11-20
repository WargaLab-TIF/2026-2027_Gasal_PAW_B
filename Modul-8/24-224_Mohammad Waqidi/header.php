<?php
require_once __DIR__ . "/midlewire.php";
cek_login("");

if (!isset($judul)) {
    $judul = "Aplikasi Penjualan";
}

$nama_user = $_SESSION['nama'] ?? $_SESSION['username'] ?? 'User';
$level_user = (int)($_SESSION['level'] ?? 0);
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($judul) ?></title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header>
    <h1>Sistem Penjualan</h1>
</header>

<nav>
    <div class="nav-left">
        <a href="index.php">Home</a>
        <?php if ($level_user === 1) { ?>
            <a href="index.php#data-master">Data Master</a>
        <?php } ?>
        <a href="transaksi.php">Transaksi</a>
        <a href="laporan.php">Laporan</a>
    </div>
    <div class="nav-right">
        <span class="user-badge"><?= htmlspecialchars($nama_user) ?></span>
        <a class="logout-link" href="logout.php">Logout</a>
    </div>
</nav>

<main class="wrap">
