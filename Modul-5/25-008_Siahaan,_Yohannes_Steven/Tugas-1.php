<!DOCTYPE html>
<html>
<head>
	<style>
		h2 {
			font-family: arial;
			color: skyblue;
		}
		button {
			border-radius: 5px;
			padding: 10px;
			margin: 2px;
		}
		table {
		    border-collapse: collapse;
		 }
		th {
			background-color: skyblue ;
		}
		.btn-tambah {
			background-color: green;
			color: white;
		}
		.btn-edit {
			background-color: orange;
			color: white;
		}
		.btn-hapus {
			background-color: red;
			color: white;
		}
	</style>
</head>
<body>
	<h2>Data Master Supplier</h2>
	<a href="Tugas-2.php">
		<button class="btn-tambah">Tambah data</button>
	</a>
	<hr><br>
	<?php
	require "koneksidb.php";
	$query = "SELECT nomor, nama, telp, alamat FROM perusahaan";
	$result = mysqli_query($conn, $query);

	echo "<table border='1' cellpadding='10'>";
	echo "<tr><th>No</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Tindakan</th></tr>";
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<tr>";
			echo "<td>" . $row["nomor"] . "</td>";
			echo "<td>" . $row["nama"] . "</td>";
			echo "<td>" . $row["telp"] . "</td>";
			echo "<td>" . $row["alamat"] . "</td>";
			echo "<td><a href='Tugas-3.php?nomor=".$row["nomor"]."'><button class='btn-edit'>Edit</button></a><a onclick='hapus()' href='Tugas-4.php?nomor=".$row["nomor"]."'><button class='btn-hapus'>Hapus</button></a></td>";
			echo "</tr>";
		}
	} else {
		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td></td>";
		echo "</tr>";
	}
	echo "</table>";

	?>
	<script>
		function hapus() {
			confirm("Anda yakin akan menghapus supplier ini?")
		}
	</script>
</body>
</html>
