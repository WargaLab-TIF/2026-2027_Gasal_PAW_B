<?php // butuh session aktif: halaman pemanggil sudah memuat midlewire.php ?>
<div>
	<a href="index.php">Home</a>
	<?php if ($_SESSION['level'] == 1) { ?>
	| <details style="display:inline">
		<summary style="display:inline">Data Master</summary>
		<a href="barang.php">Data Barang</a><br>
		<a href="supplier.php">Data Supplier</a><br>
		<a href="pelanggan.php">Data Pelanggan</a><br>
		<a href="user.php">Data User</a>
	</details>
	<?php } ?>
	| <a href="transaksi.php">Transaksi</a>
	| <a href="laporan.php">Laporan</a>
	| <?= htmlspecialchars($_SESSION['nama']) ?>
	| <a href="logout.php">Logout</a>
</div>
<hr>
