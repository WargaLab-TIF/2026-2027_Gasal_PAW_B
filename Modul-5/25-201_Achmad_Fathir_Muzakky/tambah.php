<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbsupply";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['simpan'])) {
    $nama = ($_POST['nama']);
    $telp = ($_POST['telp']); 
    $alamat = ($_POST['alamat']);

    $query = "INSERT INTO data (nama, telp, alamat)
    VALUES ('$nama', '$telp', '$alamat')";

    if (mysqli_query($conn, $query)) {
        echo "Data Baru Berhasil Ditambahkan";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<h2>Tambah Data Master Supplier Baru</h2>

<form method="post">
    Nama <input type="text" name="nama"> <br><br>
    Telp <input type="number" name="telp"> <br><br>
    Alamat <input type="text" name="alamat"> <br><br>
    <button type="submit" name="simpan">Simpan</button>
</form>
<a href="main.php"><button>Batal</button></a> 