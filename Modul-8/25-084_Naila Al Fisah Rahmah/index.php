<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home Aplikasi Penjualan</title>

    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f4fa;
            padding: 30px;
            color: #252b40;
        }

        h1 {
            color: #493b78;
            text-align: center;
        }

        nav {
            background: #493b78;
            padding: 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        nav a {
            display: inline-block;
            color: white;
            background: #8064c8;
            padding: 9px 15px;
            border-radius: 7px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            background: #6248a5;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background: white;
            min-width: 160px;
            top: 100%;
            left: 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            border-radius: 8px;
            z-index: 10;
        }

        .dropdown-content a {
            display: block;
            color: #493b78;
            background: white;
            border-radius: 0;
        }

        .dropdown-content a:hover {
            background: #f0edfa;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .logout {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
        }

        .content {
            background: white;
            padding: 30px;
            margin-top: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            text-align: center;
        }
    </style>
</head>

<body>

    <h1>APLIKASI PENJUALAN</h1>

    <nav>
        <a href="index.php">Home</a>

        <?php if ($_SESSION['level'] == 1) { ?>
            <div class="dropdown">
                <a href="#">Data Master</a>

                <div class="dropdown-content">
                    <a href="barang.php">Data Barang</a>
                    <a href="supplier.php">Data Supplier</a>
                    <a href="pelanggan.php">Data Pelanggan</a>
                    <a href="user.php">Data User</a>
                </div>
            </div>
        <?php } ?>

        <a href="transaksi.php">Transaksi</a>
        <a href="laporan.php">Laporan</a>

        <div class="logout">
            <span>Halo, <?= $_SESSION['nama']; ?></span>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="content">
        <h2>Selamat Datang di Aplikasi Penjualan</h2>
        <p>Silakan pilih menu untuk mengelola data atau melihat transaksi.</p>
    </div>

</body>
</html>