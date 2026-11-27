<!DOCTYPEhtml>
<html>
	<head>
		<title>Master-DetailExample</title>
	</head>
	<body>
		<h1>DaftarMahasiswa</h1>
		<tableborder="1">
		<tr>
				<th>NIM</th>
				<th>Nama</th>
				</tr>
				<?php
//KoneksikedatabaseMySQL

	$koneksi=mysqli_connect("localhost","username","password","nama_database");

//Periksakoneksi	
					if(mysqli_connect_error()){

	die("Koneksidatabasegagal:".mysqli_connect_error());}

//Queryuntukmengambildatamahasiswa
		$query_mahasiswa="SELECTNIM,NamaFROMmahasiswa";
		$result_mahasiswa=mysqli_query($koneksi,$query_mahasiswa);

//Tampilkandatamahasiswa
			while($row=mysqli_fetch_assoc($result_mahasiswa)){
				echo"<tr>";
				echo"<td>".$row['NIM']."</td>";
				echo"<td>".$row['Nama']."</td>";
				echo"</tr>";
}

		mysqli_close($koneksi);
		?>
	</table>

		<h1>DaftarMataKuliah</h1>
		<tableborder="1">
		<tr>
		<th>MataKuliah</th>
		<th>Mahasiswa</th>
		</tr>
		<?php
//KoneksikedatabaseMySQL

$koneksi=mysqli_connect("localhost","username","password","nama_database");


//Queryuntukmengambildatamatakuliahyangdiambilmahasiswa
				$query_matkul="SELECTNamaMataKuliah,NIMFROMmata_kuliah";
				$result_matkul=mysqli_query($koneksi,$query_matkul);

//Tampilkandatamatakuliah
				while($row=mysqli_fetch_assoc($result_matkul)){
						echo"<tr>";
						echo"<td>".$row['NamaMataKuliah']."</td>";
						echo"<td>".$row['NIM']."</td>";
						echo"</tr>";
				}

						mysqli_close($koneksi);
						?>
				</table>
		</body>
</html>