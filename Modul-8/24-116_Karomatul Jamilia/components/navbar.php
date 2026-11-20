<?php $base = $base ?? ""; ?>
<style>
    body { font-family: sans-serif; margin: 0; }
    .navbar { background: #1f4e8c; display: flex; justify-content: space-between; margin-bottom: 20px; }
    .navbar > div { display: flex; }
    .navbar a { color: white; text-decoration: none; padding: 15px; display: block; }
    .navbar a:hover { background: #163b6b; }
    .dropdown { position: relative; }
    .dropdown-isi { display: none; position: absolute; background: #1f4e8c; min-width: 160px; z-index: 5; }
    .dropdown:hover .dropdown-isi { display: block; }
    .navbar ~ * { margin-left: 20px; margin-right: 20px; }
</style>
<div class="navbar">
    <div>
        <a href="<?= $base ?>index.php"><b>Sistem Penjualan</b></a>
        <a href="<?= $base ?>index.php">Home</a>

        <?php if ($_SESSION['level'] == 1) { ?>
            <div class="dropdown">
                <a href="#">Data Master &#9662;</a>
                <div class="dropdown-isi">
                    <a href="<?= $base ?>barang/index.php">Data Barang</a>
                    <a href="<?= $base ?>supplier/index.php">Data Supplier</a>
                    <a href="<?= $base ?>pelanggan/index.php">Data Pelanggan</a>
                    <a href="<?= $base ?>user/index.php">Data User</a>
                </div>
            </div>
        <?php } ?>

        <a href="<?= $base ?>transaksi.php">Transaksi</a>
        <a href="<?= $base ?>laporan.php">Laporan</a>
    </div>
    <div class="dropdown">
        <a href="#"><?= htmlspecialchars($_SESSION['nama']) ?> &#9662;</a>
        <div class="dropdown-isi" style="right: 0;">
            <a href="<?= $base ?>logout.php">Logout</a>
        </div>
    </div>
</div>
