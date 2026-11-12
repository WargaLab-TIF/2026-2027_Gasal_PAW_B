<?php 
if (!isset($judul)) {
    $judul = "Aplikasi Penjualan"; 
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($judul) ?></title>
    <link rel="stylesheet" href="/penjualan/assets/style.css">
</head>
<body>

<header>
    <h1>Penjualan</h1>
    <div>Modul 6 - Pengelolaan Master Detil Data</div>
</header>

<nav>
    <a href="../index.php">Beranda</a>
    <a href="../supplier/index.php">Supplier</a>
    <a href="../pelanggan/index.php">Pelanggan</a>
    <a href="../barang/index.php">Barang</a>
    <a href="../user/index.php">User</a>
    <a href="../transaksi/index.php">Transaksi</a>
</nav>

<main class="wrap">