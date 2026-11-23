<?php
include "koneksi.php";

$sql = "SELECT id, nama, telp, alamat FROM supplier";
$hasil = mysqli_query($koneksi, $sql);

if (mysqli_num_rows($hasil) > 0){
	echo "<h2>Data Master Supplier</h2>";
	echo "<a href='insert.php'><button>Tambah Data</button></a><br><br>";
	echo "<table border='1'>";
	echo "<tr><th>No</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Tindakan</th>";
	while ($row = mysqli_fetch_assoc($hasil)) {
		echo "<tr>";
		echo "<td>" . $row["id"] . "</td>";
		echo "<td>" . $row["nama"] . "</td>";
		echo "<td>" . $row["telp"] . "</td>";
		echo "<td>" . $row["alamat"] . "</td>";
		echo "<td><button><a href='edit.php?id=" . $row["id"] . "'>Edit</a></button>";
		echo "<button><a href='hapus.php?id=" . $row["id"] . "'";
        echo "onclick=\"return confirm('Anda yakin akan menghapus supplier ini?')\">Hapus</a></button>";
	}

} else {
	echo "<tr>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "<td></td>";
	echo "</table>";
}

?>