<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		Tambah Data Supplier
	</title>
</head>
<body>

<fieldset>

<?php
include "koneksi.php";

if (isset($_POST["Simpan"])) {
  $nama = htmlspecialchars($_POST["Nama"]);
  $telp = htmlspecialchars($_POST["Telp"]);
  $alamat = htmlspecialchars($_POST["Alamat"]);

  $query = "INSERT INTO data_supplier (Nama, Telp, Alamat) 
  			VALUES ('$nama', '$telp', '$alamat')";

  if (mysqli_query($conn, $query)) {
    echo "Data Berhasil di tambahkan!";
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
?>

	<h2 style="color: blue;">Tambah Data Master Supplier Baru</h2>
	<table cellpadding="5">
		<form method="POST">
				<tr>
					<td><label for="Nama">Nama  </label></td>
					<td><input type="text" name="Nama" placeholder="Nama" size="30" required> </td>
				</tr>
				<tr>
					<td><label for="Telp">Telp  </label></td>
					<td><input type="text" name="Telp" placeholder="telp"size="30" required></td>
				</tr>
				<tr>
					<td><label for="Alamat">Alamat  </label></td>
					<td><input type="text" name="Alamat" placeholder="alamat" size="30" required></td>
				</tr>
				<tr>
					<td></td>
					<td> <input type="submit" name="Simpan" value="Simpan">

		</form>
					<a href="index.php"><input type="submit" name="submit" value="batal"></a> </td>	
				</tr>	
	</table>

</fieldset>

<!-- sesuaikan format html nya dan tabelnya agar sesuai sama yang di index untuk echo td>  -->
</body>
</html>

