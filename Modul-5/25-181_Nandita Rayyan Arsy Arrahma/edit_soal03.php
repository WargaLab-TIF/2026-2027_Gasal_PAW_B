<?php 
	include 'koneksi.php';

	$id = $_GET['id'];
	$result = mysqli_query($conn, "SELECT * From supplier WHERE id = $id");
	$row = mysqli_fetch_array($result);

	if (isset($_POST['update'])) {
		$nama = $_POST['nama'];
		$telp = $_POST['telp'];
		$alamat = $_POST['alamat'];

		$query = "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id=$id";
		if (mysqli_query($conn, $query)) {
			header("Location: index.php");
		} else {
			echo "Gagal mengupdate data: " . mysqli_error($conn);
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
	    <title>Edit Data Master Supplier</title>
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
	    <h2>Edit Data Master Supplier</h2>
	    <form method="POST" action="">
	        <div class="tiap-kolom">
	            <label>Nama</label>
	            <input type="text" name="nama" value="<?php echo $row['nama']; ?>" required>
	        </div>
	        <div class="tiap-kolom">
	            <label>Telp</label>
	            <input type="text" name="telp" value="<?php echo $row['telp']; ?>" required>
	        </div>
	        <div class="tiap-kolom">
	            <label>Alamat</label>
	            <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>" required>
	        </div>
	        <button type="submit" name="update" class="update">Update</button>
	        <a href="index.php" class="batal">Batal</a>
	    </form>
	</body>
</html>