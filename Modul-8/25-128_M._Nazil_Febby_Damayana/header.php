<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Penjualan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Sistem Penjualan</a>
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>

            <?php if ($_SESSION['level'] == 1) { ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Data Master</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="barang.php">Data Barang</a></li>
                    <li><a class="dropdown-item" href="supplier.php">Data Supplier</a></li>
                    <li><a class="dropdown-item" href="pelanggan.php">Data Pelanggan</a></li>
                    <li><a class="dropdown-item" href="user.php">Data User</a></li>
                </ul>
            </li>
            <?php } ?>

            <li class="nav-item"><a class="nav-link" href="transaksi.php">Transaksi</a></li>
            <li class="nav-item"><a class="nav-link" href="laporan.php">Laporan</a></li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><?= h($_SESSION['nama']) ?></a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
<div class="container py-4">
