<?php
include_once 'auth.php';
wajibLogin();
?>

<nav style="background-color: #07549b; padding: 15px; color: white;">

    <a href="index.php" style="color:white;">Home</a>

    <?php if ($_SESSION['level'] == 1) { ?>

        <span style="color:white;"> | Data Master:</span>

        <a href="barang.php" style="color:white;">Barang</a>

        <a href="supplier.php" style="color:white;">Supplier</a>

        <a href="pelanggan.php" style="color:white;">Pelanggan</a>

    <?php } ?>

    <a href="transaksi.php" style="color:white;"> | Transaksi</a>

    <a href="laporan.php" style="color:white;"> | Laporan</a>

    <span style="float:right;">
        <?php echo htmlspecialchars($_SESSION['nama']); ?>

        <a href="logout.php" style="color:white;">
            | Logout
        </a>
    </span>

</nav>

<br>