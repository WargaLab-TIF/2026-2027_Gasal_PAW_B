<?php
$level_user = $_SESSION['level'] ?? 0;
$nama_user = $_SESSION['nama'] ?? "";
?>
<style>
    .navbar { background: #08427c; color: white; padding: 12px 16px; margin-bottom: 15px; }
    .navbar a { color: white; text-decoration: none; margin-right: 15px; }
    .nav-kanan { float: right; }
    .dropdown { display: inline-block; position: relative; }
    .dropdown-isi { display: none; position: absolute; background: white; border: 1px solid #ccc; min-width: 140px; }
    .dropdown-isi a { color: black; display: block; padding: 6px 10px; margin: 0; }
    .dropdown:hover .dropdown-isi { display: block; }
</style>

<div class="navbar">
    <b>Sistem Penjualan</b>
    <a href="index.php">Home</a>
    <?php if ($level_user == 1): ?>
        <div class="dropdown">
            <a href="#">Data Master ▾</a>
            <div class="dropdown-isi">
                <a href="barang.php">Data Barang</a>
                <a href="supplier.php">Data Supplier</a>
                <a href="pelanggan.php">Data Pelanggan</a>
                <a href="user.php">Data User</a>
            </div>
        </div>
    <?php endif; ?>
    <a href="transaksi.php">Transaksi</a>
    <a href="report.php">Laporan</a>

    <div class="nav-kanan">
        <div class="dropdown">
            <a href="#" style="margin-right: 0;"><?= htmlspecialchars($nama_user) ?> ▾</a>
            <div class="dropdown-isi" style="right: 0;">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
</div>