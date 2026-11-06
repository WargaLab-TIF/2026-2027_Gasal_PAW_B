<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbsupply";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$nomor = $_GET['nomor'];

if (isset($_POST['simpan'])) {
    $nama = ($_POST['nama']);
    $telp = ($_POST['telp']);
    $alamat = ($_POST['alamat']);

    $query = "UPDATE data
            SET nama = '$nama', telp = '$telp', alamat = '$alamat'
            WHERE nomor = $nomor";

    if (mysqli_query($conn, $query)) {
        echo "Data Berhasil di Update";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}

$query = "SELECT nama, telp, alamat FROM data WHERE nomor = $nomor";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>

<h2>Edit Data Master Supplier</h2>

<form method="post">
    Nama <input type="text" name="nama" value="<?php echo $row['nama']; ?>"> <br><br>
    Telp <input type="number" name="telp" value="<?php echo $row['telp']; ?>"> <br><br>
    Alamat <input type="text" name="alamat" value="<?php echo $row['alamat']; ?>"> <br><br>
    <button type="submit" name="simpan">Simpan</button>
</form>
<a href="main.php"><button>Batal</button></a>