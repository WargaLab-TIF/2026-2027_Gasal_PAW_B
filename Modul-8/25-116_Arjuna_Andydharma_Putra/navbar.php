<?php
// navbar harus dipanggil setelah cek login
$level = $_SESSION['level'];
$nama  = $_SESSION['nama'];

// tentukan base path biar link tetap benar dari subfolder
$base = '';
if (strpos($_SERVER['PHP_SELF'], '/barang/') !== false ||
    strpos($_SERVER['PHP_SELF'], '/supplier/') !== false ||
    strpos($_SERVER['PHP_SELF'], '/pelanggan/') !== false ||
    strpos($_SERVER['PHP_SELF'], '/user/') !== false ||
    strpos($_SERVER['PHP_SELF'], '/transaksi/') !== false ||
    strpos($_SERVER['PHP_SELF'], '/laporan/') !== false) {
    $base = '../';
}
?>
<style>
    .nav {
        background: #2c3e50;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .nav a {
        color: white;
        text-decoration: none;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 14px;
    }
    .nav a:hover {
        background: #34495e;
    }
    .nav .brand {
        font-weight: bold;
        margin-right: 20px;
        color: #ecf0f1;
    }
    .nav .right {
        margin-left: auto;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .nav .user {
        color: #bdc3c7;
        font-size: 13px;
    }
    .nav .logout {
        background: #e74c3c;
    }
    .nav .logout:hover {
        background: #c0392b;
    }
    .submenu {
        background: #34495e;
        padding: 8px 20px;
        display: flex;
        gap: 10px;
    }
    .submenu a {
        color: #ecf0f1;
        text-decoration: none;
        font-size: 13px;
        padding: 4px 10px;
        border-radius: 3px;
    }
    .submenu a:hover {
        background: #2c3e50;
    }
</style>

<div class="nav">
    <span class="brand">Sistem Penjualan</span>
    <a href="<?= $base ?>index.php">Home</a>

    <?php if ($level == 1) { ?>
        <a href="<?= $base ?>barang/index.php">Data Master</a>
    <?php } ?>

    <a href="<?= $base ?>transaksi/index.php">Transaksi</a>
    <a href="<?= $base ?>laporan/index.php">Laporan</a>

    <div class="right">
        <span class="user"><?= htmlspecialchars($nama) ?> (<?= $level == 1 ? 'Owner' : 'Kasir' ?>)</span>
        <a href="<?= $base ?>logout.php" class="logout">Logout</a>
    </div>
</div>

<?php if ($level == 1) { ?>
<div class="submenu">
    <a href="<?= $base ?>barang/index.php">Data Barang</a>
    <a href="<?= $base ?>supplier/index.php">Data Supplier</a>
    <a href="<?= $base ?>pelanggan/index.php">Data Pelanggan</a>
    <a href="<?= $base ?>user/index.php">Data User</a>
</div>
<?php } ?>
