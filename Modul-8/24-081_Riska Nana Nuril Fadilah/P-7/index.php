<?php
require "koneksi.php";
include "midlewire.php";

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$query_barang = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM barang");
$query_supplier = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM supplier");
$query_pelanggan = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM pelanggan");
$query_transaksi = mysqli_query($conn, "SELECT COUNT(*) AS jumlah FROM transaksi");

$barang = mysqli_fetch_assoc($query_barang);
$supplier = mysqli_fetch_assoc($query_supplier);
$pelanggan = mysqli_fetch_assoc($query_pelanggan);
$transaksi = mysqli_fetch_assoc($query_transaksi);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halaman Utama</title>

    <style>
        body {
            font-family: Arial;
            margin: 30px;
        }

        .navbar {
            background: #5b9aaa;
            padding: 12px;
            margin-bottom: 25px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: inline-block;
        }

        .navbar a:hover {
            background: #477d8a;
        }

        .navbar span {
            color: white;
            margin-left: 10px;
        }

        .navbar form {
            display: inline;
        }

        .logout {
            background: #c9302c;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            margin-left: 10px;
        }

        h2 {
            color: #5b9aaa;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #d9edf7;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="index.php">Home</a>

        <?php if ($_SESSION['level'] == 1) { ?>
            <a href="barang.php">Data Barang</a>
            <a href="supplier.php">Data Supplier</a>
            <a href="pelanggan.php">Data Pelanggan</a>
            <a href="user.php">Data User</a>
        <?php } ?>

        <a href="transaksi.php">Transaksi</a>
        <a href="report.php">Laporan</a>

        <span>Nama: <?= htmlspecialchars($_SESSION['nama']) ?></span>

        <form action="" method="post">
            <button type="submit" name="logout" class="logout">
                Logout
            </button>
        </form>
    </div>

    <h2>Aplikasi Penjualan</h2>

    <h3>Home</h3>

    <table>
        <tr>
            <th>Nama Data</th>
            <th>Jumlah Data</th>
        </tr>

        <tr>
            <td>Barang</td>
            <td><?= $barang['jumlah'] ?></td>
        </tr>

        <tr>
            <td>Supplier</td>
            <td><?= $supplier['jumlah'] ?></td>
        </tr>

        <tr>
            <td>Pelanggan</td>
            <td><?= $pelanggan['jumlah'] ?></td>
        </tr>

        <tr>
            <td>Transaksi</td>
            <td><?= $transaksi['jumlah'] ?></td>
        </tr>
    </table>

</body>
</html>