<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "db_supplier";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['update'])) {
    $nomor  = $_POST['nomor'];
    $nama   = htmlspecialchars($_POST['nama']);
    $telp   = htmlspecialchars($_POST['telp']);
    $alamat = htmlspecialchars($_POST['alamat']);

    $sql = "UPDATE data_master_supplier 
            SET Nama = '$nama', Telp = '$telp', Alamat = '$alamat' 
            WHERE Nomor = '$nomor'";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error saat update: " . mysqli_error($conn);
    }
}

$nomor = isset($_GET['nomor']) ? $_GET['nomor'] : '';
$query = "SELECT Nomor, Nama, Telp, Alamat FROM data_master_supplier WHERE Nomor = '$nomor'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data tidak ditemukan!");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Master Supplier</title>
</head>
<body>

    <h2>Edit Data Master Supplier</h2>

    <form action="" method="POST">
        <input type="hidden" name="nomor" value="<?php echo $data['Nomor']; ?>">

        <table>
            <tr>
                <td><label for="Nama">Nama</label></td>
                <td><input type="text" id="Nama" name="nama" value="<?php echo $data['Nama']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="Telp">Telp</label></td>
                <td><input type="text" id="Telp" name="telp" value="<?php echo $data['Telp']; ?>" required></td>
            </tr>
            <tr>
                <td><label for="Alamat">Alamat</label></td>
                <td><input type="text" id="Alamat" name="alamat" value="<?php echo $data['Alamat']; ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="submit" name="update" value="Simpan Perubahan">
                    <a href="index.php"><input type="button" value="Batal"></a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>
