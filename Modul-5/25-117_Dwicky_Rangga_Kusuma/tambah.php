<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $sql = "INSERT INTO supplier (nama, Telp, Alamat)
            VALUES ('$nama', '$telp', '$alamat')";

    if (mysqli_query($conn, $sql)) {
        mysqli_close($conn);
        header("Location: index.php");
        exit;
    } else {
        echo "Data gagal ditambahkan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Supplier</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
            color: #555;
        }
        h2 {
            color: #43899b;
        }
        input {
            padding: 9px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button, a {
            padding: 9px 15px;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        button {
            background: #5cb85c;
        }
        a {
            background: #c9302c;
        }
    </style>
</head>
<body>
<h2>Tambah Data Master Supplier Baru</h2>
<form method="POST">
    <p>
        Nama
        <input type="text" name="nama" required>
    </p>
    <p>
        Telp
        <input type="text" name="telp" required>
    </p>
    <p>
        Alamat
        <input type="text" name="alamat" required>
    </p>
    <button type="submit" name="simpan">Simpan</button>
    <a href="index.php">Batal</a>
</form>
</body>
</html>

<?php
mysqli_close($conn);
?>