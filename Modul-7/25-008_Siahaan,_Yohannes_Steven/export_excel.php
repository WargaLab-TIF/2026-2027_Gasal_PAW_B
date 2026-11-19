<?php
header("Content-Type:application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan.xls");

$koneksi = mysqli_connect("localhost", "root", "", "dbpenjualan");
if (mysqli_connect_error()) {
	die("Koneksi database gagal: " . mysqli_connect_error());
}

$rekap = [];

if (!empty($_GET['mulai']) && !empty($_GET['selesai'])) {
	$mulai = $_GET['mulai'];
	$selesai = $_GET['selesai'];

	$q = "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai' GROUP BY DATE(waktu_transaksi) ORDER BY tgl ASC";
	$res = mysqli_query($koneksi, $q);
	while ($r = mysqli_fetch_assoc($res)) {
		$rekap[] = $r;
	}
}
?>
<table border="1">
	<tr><th>No</th><th>Total</th><th>Tanggal</th></tr>
	<?php $no = 1; foreach ($rekap as $row): ?>
	<tr>
		<td><?= $no++; ?></td>
		<td>Rp. <?= number_format($row['total_harian'], 0, ',', '.'); ?></td>
		<td><?= $row['tgl']; ?></td>
	</tr>
	<?php endforeach; ?>
</table>