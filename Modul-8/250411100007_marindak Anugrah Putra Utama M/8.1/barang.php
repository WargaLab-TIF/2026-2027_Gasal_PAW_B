<?php
$hanya_owner = true;
require "fungsi.php";

$data = getBukuWithKategori();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Data Barang</title>
</head>
<body>
	<?php include "components/navbar.php" ?>
	<h1>Data Barang</h1>
	<a href="tambah.php">+ Tambah buku</a>
	<br><br>
	<table border="1" cellpadding="10" cellspacing="0">
		<tr>
			<th>Judul</th>
			<th>Penulis</th>
			<th>Tahun terbit</th>
			<th>Stok</th>
			<th>Nama kategori</th>
			<th>Aksi</th>
		</tr>
		<?php foreach ($data as $row): ?>
		<tr>
			<td><?= htmlspecialchars($row["judul"]) ?></td>
			<td><?= htmlspecialchars($row["penulis"]) ?></td>
			<td><?= htmlspecialchars($row["tahun_terbit"]) ?></td>
			<td><?= htmlspecialchars($row["stok"]) ?></td>
			<td><?= htmlspecialchars($row["nama_kategori"]) ?></td>
			<td>
				<a href="edit.php?id_buku=<?= $row["id_buku"] ?>">Edit</a> |
				<a href="hapus.php?id_buku=<?= $row["id_buku"] ?>" onclick="return confirm('Hapus buku ini?')">Hapus</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</body>
</html>
