<?php 
	include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Data Master Supplier</title>
		<style>
			h2 {
				color: #2980b9;
			}
			.tambah-data {
				background-color: #27ae60;
				color: white;
				padding: 8px 12px;
				text-decoration: none;
				border-radius: 4px;
				float: right;
				margin-bottom: 10px;
			}
			table {
				width: 100%;
				border-collapse: collapse;
				margin-top: 10px;
			}
			th, td {
				border: 1px;
				solid: #ddd;
				padding: 10px;
				text-align: left;
			}
			th {
				background-color: pink;
			}
			.edit {
				background-color: #e67e22;
				color: white;
				padding: 5px 10px;
				text-decoration: none;
				border-radius: 3px;
			}
			.hapus {
				background-color: #c0392b; 
				color: white;
				padding: 5px 10px; 
				text-decoration: none;
				border-radius: 3px; 
				border: none; 
				cursor: pointer;
			}
		</style>
	</head>
	<body>
		<h2>Data Master Supplier</h2>
		<a href="tambah_soal02.php" class="tambah-data">Tambah Data</a>
		<table>
			<tr>
				<th>No</th>
				<th>Nama</th>
				<th>Telp</th>
				<th>Tindakan</th>
			</tr>
			<?php
				$no = 1;
				$query = mysqli_query($conn, "SELECT * FROM supplier");
				while ($row = mysqli_fetch_array($query)) {
				?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo $row['nama']; ?></td>
					<td><?php echo $row['telp']; ?></td>
					<td><?php echo $row['alamat']; ?></td>
					<td>
						<a href="edit_soal03.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a>
						<a href="hapus_soal04.php?id=<?php echo $row['id']; ?>" class="hapus" onclick="return confirm('Anda yakin akan menghapus supplier ini?')">Hapus</a>
					</td>
				</tr>
			<?php } ?>
		</table>
	</body>
</html>