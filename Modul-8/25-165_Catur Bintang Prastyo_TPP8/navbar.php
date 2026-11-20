<?php
$level = $_SESSION['level'];
?>
<div style="background:#004a8f; color:#fff; padding:10px;">
    <b>Sistem Penjualan</b> |
    <a href="index.php" style="color:#fff">Home</a> |
    <?php if ($level == 1) { ?>
        Data Master:
        <a href="crud.php?m=barang" style="color:#fff">Data Barang</a> |
        <a href="crud.php?m=supplier" style="color:#fff">Data Supplier</a> |
        <a href="crud.php?m=pelanggan" style="color:#fff">Data Pelanggan</a> |
        <a href="crud.php?m=user" style="color:#fff">Data User</a> |
        <a href="transaksi.php" style="color:#fff">Transaksi</a> |
        <a href="laporan.php" style="color:#fff">Laporan</a>
    <?php } elseif ($level == 2) { ?>
        <a href="transaksi.php" style="color:#fff">Transaksi</a> |
        <a href="laporan.php" style="color:#fff">Laporan</a>
    <?php } ?>
    <span style="float:right">
        Hai, <?= htmlspecialchars($_SESSION['nama']) ?> |
        <a href="logout.php" style="color:#fff">Logout</a>
    </span>
</div>
<br>
