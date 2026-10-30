<?php
include 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: soal1.php");
    exit;
}

$id = $_GET['id'];

$query = "SELECT * FROM supplier WHERE id='$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data supplier tidak ditemukan!");
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id='$id'";

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
    <title>Edit Supplier</title>
</head>
<body>

<h2>Edit Data Master Supplier</h2>

<form method="POST">
    Nama <input type="text" name="nama" value="<?php echo $data['nama']; ?>">
    <br><br>

    Telp <input type="text" name="telp" value="<?php echo $data['telp']; ?>">
    <br><br>

    Alamat <input type="text" name="alamat" value="<?php echo $data['alamat']; ?>">
    <br><br>

    <button type="submit" name="update">Update</button>
    <a href="soal1.php">Batal</a>
</form>

</body>
</html>