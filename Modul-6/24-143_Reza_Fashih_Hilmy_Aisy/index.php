<?php
include "koneksi.php";

$query_supplier = mysqli_query($conn, "SELECT * FROM supplier");
$query_barang = mysqli_query($conn, "SELECT * FROM barang");
$query_pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
$query_transaksi = mysqli_query($conn, "SELECT * FROM transaksi");
$query_pembayaran = mysqli_query($conn, "SELECT * FROM pembayaran");

$jumlah_supplier = mysqli_num_rows($query_supplier);
$jumlah_barang = mysqli_num_rows($query_barang);
$jumlah_pelanggan = mysqli_num_rows($query_pelanggan);
$jumlah_transaksi = mysqli_num_rows($query_transaksi);
$jumlah_pembayaran = mysqli_num_rows($query_pembayaran);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Penjualan</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: whitesmoke;
        margin: 30px;
        color: darkslategray;
    }

    h1 {
        color: cadetblue;
    }

    p {
        font-size: 15px;
    }

    a {
        display: inline-block;
        background-color: cadetblue;
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        margin: 5px;
        border-radius: 5px;
    }

    a:hover {
        background-color: darkslategray;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
        background-color: white;
    }

    th {
        background-color: lightblue;
        color: darkslategray;
    }

    th, td {
        border: 1px solid lightgray;
        padding: 10px;
        text-align: left;
    }
</style>
</head>
<body>

<h2>Aplikasi Penjualan</h2>

<nav>
    <a href="index.php">Beranda</a>
    <a href="supplier.php">Supplier</a>
    <a href="barang.php">Barang</a>
    <a href="pelanggan.php">Pelanggan</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="pembayaran.php">Pembayaran</a>
</nav>

<h3>Dashboard</h3>

<table>
    <tr>
        <th>Nama Data</th>
        <th>Jumlah Data</th>
    </tr>
    <tr>
        <td>Supplier</td>
        <td><?= $jumlah_supplier ?></td>
    </tr>
    <tr>
        <td>Barang</td>
        <td><?= $jumlah_barang ?></td>
    </tr>
    <tr>
        <td>Pelanggan</td>
        <td><?= $jumlah_pelanggan ?></td>
    </tr>
    <tr>
        <td>Transaksi</td>
        <td><?= $jumlah_transaksi ?></td>
    </tr>
    <tr>
        <td>Pembayaran</td>
        <td><?= $jumlah_pembayaran ?></td>
    </tr>
</table>

</body>
</html>