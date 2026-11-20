<?php
include 'validasi.php';
include "koneksi.php";
wajib_login();
?>
<nav class="navbar">

    <a href="index.php">Home</a>

   <?php if ($_SESSION['level'] == 1) { ?>

    <details class="dropdown">
        <summary>Data Master</summary>

        <div class="dropdown-menu">
            <a href="data_barang.php">Data Barang</a>
            <a href="data_supplier.php">Data Supplier</a>
            <a href="data_pelanggan.php">Data Pelanggan</a>
            <a href="data_user.php">Data User</a>
        </div>
    </details>

<?php } ?>
    <a href="master-detail.php">Transaksi</a>
    <a href="laporan.php">Laporan</a>

    <span class="user">
        <?php echo htmlspecialchars($_SESSION['nama']); ?>
    </span>

    <a href="logout.php">Logout</a>

</nav>