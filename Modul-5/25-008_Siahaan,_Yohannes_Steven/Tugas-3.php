<!DOCTYPE html>
<html>
<head>
</head>
<body>
	<h2>Edit Data Master Supplier</h2>
	<hr>
	<form action="" method="POST">
		<table cellpadding="10px">
			<tr>
				<td align="right">Nama</td>
				<td>
					<input type="text" name="nama">
				</td>
			</tr>
			<tr>
				<td align="right">Telp</td>
				<td>
					<input type="text" name="telp">
				</td>
			</tr>
			<tr>
				<td align="right">Alamat</td>
				<td>
					<input type="text" name="alamat">
				</td>
			</tr>
		</table>
		<button type="submit" name="submit">Simpan</button>
	</form>
	<a href="Tugas-1.php">
		<button>Batal</button>
	</a><br><br>
	<?php
	require "koneksidb.php";
		if (isset($_POST['submit'])) {
			$nama = $_POST['nama'];
			$telp = $_POST['telp'];
			$alamat = $_POST['alamat'];
			$nomor = $_GET['nomor'];

			$query = "UPDATE perusahaan SET nama='$nama', telp='$telp', alamat='$alamat' WHERE nomor=$nomor";

			if (mysqli_query($conn, $query)) {
				echo "Data berhasil diubah";
			} else {
				echo "Error: " . mysqli_error($conn);
			}
		}
	?>
</body>
</html>