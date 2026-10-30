<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "modul5";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST["simpan"])) {
    $nama = mysqli_real_escape_string($conn, $_POST["nama"]);
    $telp = mysqli_real_escape_string($conn, $_POST["telp"]);
    $alamat = mysqli_real_escape_string($conn, $_POST["alamat"]);
    $query = "INSERT INTO supplier (nama, telp, alamat)
              VALUES ('$nama', '$telp', '$alamat')";
    if (mysqli_query($conn, $query)) {
        header("Location: soal1.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Supplier</title>
</head>
<body>

<h2>Tambah Data Supplier Baru</h2>

<form method="POST">
    Nama:
    <input type="text" name="nama" required>
    <br><br>

    Telp:
    <input type="text" name="telp" required>
    <br><br>

    Alamat:
    <input type="text" name="alamat" required>
    <br><br>

    <button type="submit" name="simpan">Simpan</button>
    <a href="soal1.php">Batal</a>
</form>

</body>
</html>