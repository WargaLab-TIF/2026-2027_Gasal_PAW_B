<?php 
$judul = "Beranda"; 
include "header.php"; 
?>

<h2>Dashboard Aplikasi Penjualan</h2>
<p>Gunakan menu di atas untuk mengelola data master dan transaksi.</p>

<div class="grid">
    <div>
        <h3>Data Master</h3>
        <ul>
            <li><a href="supplier/index.php">Supplier</a></li>
            <li><a href="pelanggan/index.php">Pelanggan</a></li>
            <li><a href="barang/index.php">Barang</a></li>
            <li><a href="user/index.php">User</a></li>
        </ul>
    </div>
    <div>
        <h3>Transaksi</h3>
        <p><a class="btn" href="transaksi/index.php">Kelola Transaksi</a></p>
        <p class="muted">Buka transaksi untuk menambahkan detail barang dan melihat total otomatis.</p>
    </div>
</div>

<?php include "footer.php"; ?>