<?php
require_once __DIR__ . "/midlewire.php";
cek_login("");

if (!isset($judul)) {
    $judul = "Aplikasi Penjualan";
}

$nama_user = $_SESSION['nama'] ?? $_SESSION['username'] ?? 'User';
$level_user = (int)($_SESSION['level'] ?? 0);
$label_level = ($level_user === 1) ? 'Owner' : 'Kasir';
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
    <div>Modul 8 - Session dan Security</div>
</header>

<nav>
    <div class="nav-left">
        <a href="index.php">Home</a>
        <?php if ($level_user === 1) { ?>
            <div class="dropdown">
                <a href="javascript:void(0)" class="dropdown-toggle">Data Master &#9662;</a>
                <div class="dropdown-menu">
                    <a href="barang/index.php">Data Barang</a>
                    <a href="supplier/index.php">Data Supplier</a>
                    <a href="pelanggan/index.php">Data Pelanggan</a>
                    <a href="user/index.php">Data User</a>
                </div>
            </div>
        <?php } ?>
        <a href="transaksi/index.php">Transaksi</a>
        <a href="laporan/index.php">Laporan</a>
    </div>
    <div class="nav-right">
        <span class="user-badge"><?= htmlspecialchars($nama_user) ?> (<?= $label_level ?>)</span>
        <a class="logout-link" href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
    </div>
</nav>

<main class="wrap">
