<!DOCTYPE html>
<html>
<head>
 	<title>Laporan Penjualan dan Grafik</title>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 <style>
 	table { border-collapse: collapse; width: 100%; margin-top: 15px;
}
 th, td { border: 1px solid #000; padding: 6px; text-align: left;
}
	@media print { .no-print { display: none !important; } }
</style>
</head>
<body>
	<div class="no-print">
		<h1>Rekap Laporan Penjualan</h1>
		<form method="GET">
			Dari: <input type="date" name="mulai" value="<?= $_GET['mulai']
				?? '' ?>" required>
			Sampai: <input type="date" name="selesai" value="<?=
					$_GET['selesai'] ?? '' ?>" required>
					<button type="submit">Tampilkan</button>
				</form>
				<br>
				<button onclick="window.print()">Cetak</button>
				<a href="export_excel.php?mulai=<?= $_GET['mulai'] ?? ''
				?>&selesai=<?= $_GET['selesai'] ?? '' ?>">
				<button type="button">Excel</button>
			</div>

			<?php
// Koneksi ke database MySQL
			$hostname = "localhost";
			$username = "root";
			$password = "";
			$database = "penjualan";
			$port = 33061;

			$koneksi = mysqli_connect(
			    $hostname,
			    $username,
			    $password,
			    $database,
			    $port
			);

			if (!$koneksi) {
			    die("Koneksi gagal: " . mysqli_connect_error());
			}
			$labels = []; $data_total = []; $rekap = [];
			$total_pendapatan = 0; $total_pelanggan = 0;
			if (!empty($_GET['mulai']) && !empty($_GET['selesai'])) {
				$mulai = $_GET['mulai'];
				$selesai = $_GET['selesai'];

// Query agregasi total pendapatan harian
				$q = "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS
				total_harian
				FROM transaksi WHERE waktu_transaksi >= '$mulai'
				AND waktu_transaksi < DATE_ADD('$selesai', INTERVAL 1 DAY)
				GROUP BY DATE(waktu_transaksi) ORDER BY tgl ASC";
				$res = mysqli_query($koneksi, $q);
				while ($r = mysqli_fetch_assoc($res)) {
					$labels[] = $r['tgl'];
					$data_total[] = $r['total_harian'];
					$rekap[] = $r;
					$total_pendapatan += $r['total_harian'];
				}

// Query jumlah pelanggan unik
				$qp = "SELECT COUNT(DISTINCT pelanggang_id) AS jml FROM transaksi
				WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai'";
				$rp = mysqli_fetch_assoc(mysqli_query($koneksi, $qp));
				$total_pelanggan = $rp['jml'] ?? 0;
			}
			?>
			<?php if (!empty($labels)): ?>
				<h2>Grafik Penjualan</h2>
				<div style="width: 600px; height: 300px;"><canvas
					id="myChart"></canvas></div>
					<script>
						const ctx = document.getElementById('myChart').getContext('2d');
						new Chart(ctx, {
							type: 'bar',
							data: {
								labels: <?= json_encode($labels); ?>,
								datasets: [{ label: 'Total Penjualan', data: <?=
							json_encode($data_total); ?> }]
						}
					});
				</script>
				<h2>Rekapitulasi</h2>
				<table>
					<tr><th>No</th><th>Total</th><th>Tanggal</th></tr>
					<?php $no = 1; foreach ($rekap as $row): ?>
					<tr>
						<td><?= $no++; ?></td>
						<td>Rp. <?= number_format($row['total_harian'], 0, ',', '.');
					?></td>
					<td><?= $row['tgl']; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
		<p><b>Jumlah Pelanggan:</b> <?= $total_pelanggan; ?> Orang |
			<b>Jumlah Pendapatan:</b> Rp. <?= number_format($total_pendapatan, 0,
				',', '.'); ?></p>
			<?php else: ?>
				<p>Data transaksi tidak ditemukan. Silakan periksa tanggal yang dipilih.</p>
			<?php endif; ?>
		</body>
		</html>