<?php
require_once "middleware.php";

cekLogin();

$levelPengguna = (int)($_SESSION['level'] ?? 0);
if ($levelPengguna !== 1 && $levelPengguna !== 2) {

    header("Location: login.php");
    exit;
}

$namaPengguna = $_SESSION['nama'] ?? 'Pengguna';
$peran = ($levelPengguna === 1) ? 'Owner' : 'Kasir';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }

        .navbar {
            background-color: #0d6efd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav-left {
            display: flex;
            align-items: center;
        }

        .nav-brand {
            color: #ffffff;
            font-size: 18px;
            font-weight: bold;
            margin-right: 25px;
            text-decoration: none;
        }

        .nav-menu {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .nav-menu li {
            position: relative;
        }

        .nav-menu a {
            display: block;
            color: #ffffff;
            text-decoration: none;
            padding: 15px 16px;
            font-size: 14px;
        }

        .nav-menu a:hover, .nav-menu a.active {
            background-color: #0b5ed7;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #ffffff;
            min-width: 170px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.15);
            z-index: 1000;
            border-radius: 0 0 4px 4px;
        }

        .dropdown-content a {
            color: #333333;
            padding: 10px 16px;
            font-size: 13px;
        }

        .dropdown-content a:hover {
            background-color: #e9ecef;
            color: #0d6efd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
            color: #ffffff;
            font-size: 14px;
        }

        .btn-logout {
            background-color: #dc3545;
            color: #ffffff !important;
            padding: 6px 14px !important;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px !important;
            font-weight: bold;
            transition: background 0.2s;
        }

        .btn-logout:hover {
            background-color: #bb2d3b !important;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .welcome-card {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 25px 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            margin-bottom: 25px;
            border-left: 5px solid #0d6efd;
        }

        .welcome-card h2 {
            margin-top: 0;
            color: #212529;
            font-size: 22px;
        }

        .welcome-card p {
            color: #6c757d;
            margin-bottom: 0;
            line-height: 1.6;
        }

        .badge-role {
            display: inline-block;
            background-color: #e7f1ff;
            color: #0d6efd;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 8px;
        }

        .shortcut-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .shortcut-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            text-decoration: none;
            color: #333333;
            border: 1px solid #e9ecef;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .shortcut-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .shortcut-card h3 {
            margin: 0 0 10px 0;
            color: #0d6efd;
            font-size: 16px;
        }

        .shortcut-card p {
            margin: 0;
            color: #6c757d;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-left">
            <a href="index.php" class="nav-brand">Sistem Penjualan</a>
            <ul class="nav-menu">
                <li><a href="index.php" class="active">Home</a></li>

                <?php if ($levelPengguna === 1): ?>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Data Master &#9662;</a>
                    <div class="dropdown-content">
                        <a href="barang.php">Data Barang</a>
                        <a href="supplier.php">Data Supplier</a>
                        <a href="pelanggan.php">Data Pelanggan</a>
                        <a href="user.php">Data User</a>
                    </div>
                </li>
                <?php endif; ?>

                <li><a href="transaksi.php">Transaksi</a></li>
                <li><a href="laporan.php">Laporan</a></li>
            </ul>
        </div>

        <div class="nav-right">
            <span>Halo, <strong><?= htmlspecialchars($namaPengguna); ?></strong></span>
            <a href="logout.php" class="btn-logout" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Logout</a>
        </div>
    </nav>

    <div class="container">
        <div class="welcome-card">
            <h2>Selamat Datang, <?= htmlspecialchars($namaPengguna); ?>! <span class="badge-role"><?= $peran; ?></span></h2>
            <p>Anda telah berhasil masuk ke sistem menggunakan hak akses <strong><?= $peran; ?></strong>. Silakan gunakan menu navigasi di atas untuk mengelola data penjualan.</p>
        </div>

        <div class="shortcut-grid">
            <?php if ($levelPengguna === 1): ?>
            <a href="barang.php" class="shortcut-card">
                <h3>Kelola Data Barang</h3>
                <p>Lihat dan kelola inventaris master barang.</p>
            </a>
            <?php endif; ?>

            <a href="transaksi.php" class="shortcut-card">
                <h3>Data Transaksi</h3>
                <p>Lihat riwayat dan detail penjualan.</p>
            </a>

            <a href="laporan.php" class="shortcut-card">
                <h3>Laporan Penjualan</h3>
                <p>Analisis grafik omzet dan ekspor Excel.</p>
            </a>
        </div>
    </div>

</body>
</html>

