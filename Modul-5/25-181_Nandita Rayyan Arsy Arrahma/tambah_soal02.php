<?php 
	include 'koneksi.php';

	if (isset($_POST['simpan'])) {
		$nama = $_POST['nama'];
		$telp = $_POST['telp'];
		$alamat = $_POST['alamat'];

		$query = "INSERT INTO supplier (nama, telp, alamat) VALUE ('$nama', '$telp', '$alamat')";
		if (mysqli_query($conn,$query)) {
			header("Location: index.php");
		} else {
			echo "Gagal menambah data: ". mysqli_error($conn);
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
	    <title>Tambah Data Master Supplier Baru</title>
	    <style>
	        h2 {
	        	color:#2980b9;
	        }
	        .tiap-kolom {
	        	margin-bottom: 15px;
	        }
	        label {
	        	display: inline-block;
	        	width: 80px;
	        	font-weight: blod;
	        }
	        input[type="text"] {
	        	width: 300px;
	        	padding: 8px;
	        }
	        .simpan {
	        	background-color: #27ae60;
	        	color: white;
	        	padding: 8px 15px;
	        	border: none;
	        	cursor: pointer;
	        	border-radius: 4px;
	        }
	        .batal {
	        	background-color: #c0392b;
	        	color: white; 
	        	padding: 8px 15px; 
	        	text-decoration: none; 
	        	border-radius: 4px; 
	        	display: inline-block;
	        }
	    </style>
	</head>
	<body>
	    <h2>Tambah Data Master Supplier Baru</h2>
	    <form method="POST" action="">
	        <div class="tiap-kolom">
	            <label>Nama</label>
	            <input type="text" name="nama" required placeholder="Nama">
	        </div>
	        <div class="tiap-kolom">
	            <label>Telp</label>
	            <input type="text" name="telp" required placeholder="telp">
	        </div>
	        <div class="tiap-kolom">
	            <label>Alamat</label>
	            <input type="text" name="alamat" required placeholder="alamat">
	        </div>
	        <button type="submit" name="simpan" class="simpan">Simpan</button>
	        <a href="index.php" class="batal">Batal</a>
	    </form>
	</body>
</html>