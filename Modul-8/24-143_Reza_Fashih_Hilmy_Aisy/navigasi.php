<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav>
    <a href="index.php">Home</a>
    <?php if ((int) $_SESSION['level'] === 1): ?>
        | <span>Data Master</span>
        (<a href="barang.php">Data Barang</a>
        | <a href="supplier.php">Data Supplier</a>
        | <a href="pelanggan.php">Data Pelanggan</a>
        | <a href="user.php">Data User</a>)
    <?php endif; ?>
    | <a href="transaksi.php">Transaksi</a>
    | <a href="laporan.php">Laporan</a>
    | <strong><?= htmlspecialchars($_SESSION['nama'], ENT_QUOTES, 'UTF-8') ?></strong>
    | <a href="logout.php">Logout</a>
</nav>
<hr>
