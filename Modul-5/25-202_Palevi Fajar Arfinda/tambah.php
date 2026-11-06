<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "db_supplier";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['simpan'])) {
    $nama   =  htmlspecialchars($_POST['nama']);
    $telp   =  htmlspecialchars($_POST['telp']);
    $alamat =  htmlspecialchars($_POST['alamat']);

    $sql = "INSERT INTO data_master_supplier (Nama, Telp, Alamat) 
            VALUES ('$nama', '$telp', '$alamat')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Master Supplier</title>
</head>
<body>

    <h2>Tambah Data Master Supplier Baru</h2>

    <form action="" method="POST">
        <table>
            <tr>
                <td><label for="Nama">Nama</label></td>
                <td><input type="text" id="Nama" name="nama" placeholder="Nama" required></td>
            </tr>
            <tr>
                <td><label for="Telp">Telp</label></td>
                <td><input type="text" id="Telp" name="telp" placeholder="telp" required></td>
            </tr>
            <tr>
                <td><label for="Alamat">Alamat</label></td>
                <td><input type="text" id="Alamat" name="alamat" placeholder="alamat" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="simpan" value="Simpan">
                    <a href="index.php"><input type="button" value="Batal"></a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>