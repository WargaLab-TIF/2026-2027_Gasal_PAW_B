<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Data Supplier</title>
</head>
<body>
<?php include 'koneksi.php'; ?>
<a href="edi.php"></a>
<fieldset>
	<h2 style="color: blue;">Data Master Supplier</h2>
	<a href="tambah.php"> <input type="submit" name="submit" value="Tambah"></a>

	<hr>
	<?php
	$query = "SELECT Nomor, Nama, Telp, Alamat FROM data_supplier";
	$result = mysqli_query($conn, $query);

	if (mysqli_num_rows($result) > 0){
		echo "<table border='1' cellpadding='10'>";
		echo "<tr style='background-color: cyan;'><th>No</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Tindakan</th></tr>";
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<tr>";
			echo "<td>" . $row['Nomor'] . "</td>";
			echo "<td>" . $row['Nama'] . "</td>";
			echo "<td>" . $row['Telp'] . "</td>";
			echo "<td>" . $row['Alamat'] . "</td>";
			echo "<td>";
			echo "<a href='edit.php?Nomor=" . $row["Nomor"] . "'><input type='button' value='Edit'></a> ";
       		echo "<a href='hapus.php?Nomor=" . $row["Nomor"] . "' onclick=\"return confirm('Anda yakin akan menghapus supplier ini?');\"><input type='button' value='Hapus'></a>";			
       		echo "</td>";
			echo "<tr>";
		}

		echo "</table>";
	} else {
		echo "0 result";
	}
	?>
</fieldset>

</body>
</html>