<?php
require_once 'auth.php';
cekLogin();

$level = (int)$_SESSION['level'];
$nama = $_SESSION['nama'] ?: $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home - Penjualan Cemilan</title>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 30px;
        padding: 20px;
        background-color: #fff5f8;
        color: #444;
        line-height: 1.6;
    }

    h2 {
        color: #d63384;
        margin-bottom: 15px;
    }

    /* Navbar */
    .navbar {
        background-color: #e879a9;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 8px;
        margin-bottom: 25px;
    }

    .navbar-kiri {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .navbar-brand {
        color: white;
        font-size: 19px;
        font-weight: bold;
        white-space: nowrap;
    }

    .navbar-menu {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .navbar-menu a,
    .logout {
        color: white;
        padding: 8px 12px;
        text-decoration: none;
        white-space: nowrap;
    }

    .navbar-menu a:hover,
    .logout:hover {
        background-color: #d63384;
        border-radius: 6px;
    }

    /* Dropdown */
    .dropdown {
        position: relative;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #e879a9;
        min-width: 160px;
        top: 100%;
        left: 0;
        z-index: 10;
        border-radius: 6px;
    }

    .dropdown-menu a {
        display: block;
        padding: 10px;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    /* Logout */
    .logout {
        margin-left: auto;
    }

    /* Container */
    .container {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(214, 51, 132, 0.10);
    }

    /* Tampilan layar kecil */
    @media(max-width: 700px) {
        .navbar {
            flex-wrap: wrap;
            gap: 10px;
        }

        .navbar-kiri {
            flex-wrap: wrap;
        }

        .navbar-menu {
            flex-wrap: wrap;
        }
    }
</style>
</head>

<body>

<nav class="navbar">

    <div class="navbar-kiri">

        <div class="navbar-brand">
            Sistem Penjualan Cemilan
        </div>

        <div class="navbar-menu">

            <a href="index.php">Home</a>

            <?php if ($level == 1) { ?>
                <div class="dropdown">
                    <a href="#">Data Master ▾</a>

                    <div class="dropdown-menu">
                        <a href="barang.php">Data Barang</a>
                        <a href="supplier.php">Data Supplier</a>
                        <a href="pelanggan.php">Data Pelanggan</a>
                        <a href="user.php">Data User</a>
                    </div>
                </div>
            <?php } ?>

            <a href="detail.php">Transaksi</a>
            <a href="laporan.php">Laporan</a>

        </div>
    </div>

    <a class="logout" href="logout.php"
       onclick="return confirm('Yakin ingin logout?')">
        wawa
    </a>

</nav>

<div class="container">

    <h2>Selamat Datang, <?= htmlspecialchars($nama) ?>!</h2>

    <p>
        Selamat datang di Aplikasi Sistem Penjualan Cemilan.
        Silakan gunakan menu navigasi untuk mengelola data dan transaksi.
    </p>

</div>

</body>
</html>