<?php
require_once 'auth.php';
cekOwner();

include 'koneksi.php';

$level = (int)$_SESSION['level'];
$nama = $_SESSION['nama'] ?: $_SESSION['username'];

$data = mysqli_query($conn, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>

    <style>
        body {
            background: #fff5f8;
            color: #444;
            font-family: Arial;
            margin: 30px;
            padding: 20px;
            line-height: 1.6;
        }

        .navbar {
            background: #e879a9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            font-weight: bold;
        }

        .dropdown {
            display: inline-block;
            position: relative;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background: #e879a9;
            min-width: 160px;
            padding: 10px;
            border-radius: 5px;
            z-index: 10;
        }

        .dropdown-menu a {
            display: block;
            padding: 6px;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h2 {
            color: #d63384;
        }

        .btn {
            background: #e879a9;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 3px;
        }

        .btn:hover {
            background: #d63384;
        }

        .btn-danger {
            background: #dc3545;
        }

        .btn-danger:hover {
            background: #b02a37;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #e879a9;
            color: white;
        }

        th, td {
            border: 1px solid #f5d5e3;
            padding: 10px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #fff0f5;
        }

        tr:hover {
            background: #fce0eb;
        }
    </style>
</head>

<body>

<div class="navbar">
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
    <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
</div>

<div class="container">

    <h2>Data Barang</h2>

    <a href="barang_tambah.php" class="btn">+ Tambah Barang</a>

    <table>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($b = mysqli_fetch_assoc($data)) {
        ?>

        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($b['kode_barang']) ?></td>
            <td><?= htmlspecialchars($b['nama_barang']) ?></td>
            <td>Rp <?= number_format($b['harga'], 0, ',', '.') ?></td>
            <td><?= $b['stok'] ?></td>
            <td>
                <a href="barang_edit.php?id=<?= $b['id'] ?>" class="btn">
                    Edit
                </a>

                <a href="barang_hapus.php?id=<?= $b['id'] ?>"
                   class="btn btn-danger"
                   onclick="return confirm('Hapus barang ini?')">
                    Hapus
                </a>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>
