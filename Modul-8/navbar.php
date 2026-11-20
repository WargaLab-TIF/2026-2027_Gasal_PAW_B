
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id_user'])) {
    header("Location: /2026-2027_Gasal_PAW_B/Modul-8/login.php");
    exit;
}

$base = "/2026-2027_Gasal_PAW_B/Modul-8/";
?>

<style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f6f9;
    color: #333;
}

.navbar {
    background: #1e3a5f;
    padding: 16px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.brand {
    color: white;
    font-size: 20px;
    font-weight: bold;
    text-decoration: none;
}

.nav-menu {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 5px;
}

.nav-menu a {
    color: white;
    text-decoration: none;
    padding: 10px 13px;
    border-radius: 5px;
    font-size: 14px;
}

.nav-menu a:hover {
    background: #365b85;
}

.nav-menu .logout {
    background: #dc3545;
}

.nav-menu .logout:hover {
    background: #bb2d3b;
}

@media (max-width: 768px) {
    .navbar {
        padding: 15px;
    }
}
</style>

<nav class="navbar">
    <a href="<?= $base ?>index.php" class="brand">
        APLIKASI PENJUALAN
    </a>

    <div class="nav-menu">
        <a href="<?= $base ?>index.php">Home</a>

        <?php if ($_SESSION['level'] == 1) { ?>
            <a href="<?= $base ?>barang/data.php">Barang</a>
            <a href="<?= $base ?>supplier/data.php">Supplier</a>
            <a href="<?= $base ?>pelanggan/data.php">Pelanggan</a>
            <a href="<?= $base ?>user/data.php">User</a>
        <?php } ?>

        <a href="<?= $base ?>transaksi/">Transaksi</a>
        <a href="<?= $base ?>laporan/">Laporan</a>
        <a href="<?= $base ?>logout.php" class="logout">Logout</a>
    </div>
</nav>
