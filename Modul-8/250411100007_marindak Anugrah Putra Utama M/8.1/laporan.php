<?php
require "fungsi.php"; // sekaligus proteksi login (owner & kasir)

$rows = mysqli_query($connect, "
    SELECT t.tanggal, p.nama AS pelanggan, b.judul, t.jumlah, u.name AS kasir
    FROM transaksi t
    JOIN pelanggan p ON p.id_pelanggan = t.id_pelanggan
    JOIN buku b ON b.id_buku = t.id_buku
    JOIN user u ON u.id_user = t.id_user
    ORDER BY t.tanggal DESC, t.id_transaksi DESC
");
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laporan</title>
</head>
<body>
	<?php include "components/navbar.php" ?>
	<h1>Laporan Transaksi</h1>
	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>Tanggal</th>
			<th>Pelanggan</th>
			<th>Buku</th>
			<th>Jumlah</th>
			<th>Kasir</th>
		</tr>
		<?php foreach ($rows as $r): $total += $r['jumlah']; ?>
		<tr>
			<td><?= htmlspecialchars($r['tanggal']) ?></td>
			<td><?= htmlspecialchars($r['pelanggan']) ?></td>
			<td><?= htmlspecialchars($r['judul']) ?></td>
			<td><?= $r['jumlah'] ?></td>
			<td><?= htmlspecialchars($r['kasir']) ?></td>
		</tr>
		<?php endforeach ?>
		<tr>
			<th colspan="3">Total buku terjual</th>
			<th colspan="2"><?= $total ?></th>
		</tr>
	</table>
</body>
</html>
