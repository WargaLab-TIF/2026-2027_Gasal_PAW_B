<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Master Supplier</title>
</head>
<body>
<fieldset>
<?php
include "koneksi.php";

$nomor = isset($_GET['Nomor']) ? $_GET['Nomor'] : '';
$query = "SELECT Nomor, Nama, Telp, Alamat FROM data_supplier WHERE Nomor = '$nomor'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan!");
}

if (isset($_POST['update'])) {
    $nomor  = htmlspecialchars($_POST['Nomor']);
    $nama   = htmlspecialchars($_POST['Nama']);
    $telp   = htmlspecialchars($_POST['Telp']);
    $alamat = htmlspecialchars($_POST['Alamat']);

    $sql = "UPDATE data_supplier 
            SET Nama = '$nama', Telp = '$telp', Alamat = '$alamat' 
            WHERE Nomor = $nomor";

    if (mysqli_query($conn, $sql)) {
    		echo "Data berhasil di perbarui!";
        } else {
        echo "Error saat update: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>		  

    <h2 style="color: blue;">Edit Data Master Supplier</h2>

    <table>
	    <form method="POST">
        <input type="hidden" name="Nomor" value="<?php echo $data['Nomor']; ?>">
        
            <tr>
                <td><label for="Nama">Nama</label></td>
                <td><input type="text"name="Nama" value="<?php echo $data['Nama']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="Telp">Telp</label></td>
                <td><input type="text" name="Telp" value="<?php echo $data['Telp']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="Alamat">Alamat</label></td>
                <td><input type="text" name="Alamat" value="<?php echo $data['Alamat']; ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="update" value="Update">
                    <a href="index.php"><input type="button" value="Batal"></a>
                </td>
            </tr>
				</form>
		  </table>		
</fieldset>

</body>
</html>