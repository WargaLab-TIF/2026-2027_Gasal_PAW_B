<?php
require 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO supplier (nama, telp, alamat)
              VALUES ('$nama', '$telp', '$alamat')";

    if (mysqli_query($conn, $query)) {
        header("Location: tampilan.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Master Supplier</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h2 {
            color: #5b9aaa;
        }

        label {
            display: inline-block;
            width: 100px;
            margin-bottom: 15px;
        }

        input {
            padding: 8px;
            width: 200px;
        }

        button, a {
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .simpan {
            background-color: #5cb85c;
        }

        .batal {
            background-color: #c9302c;
        }
    </style>
</head>

<body>

    <h2>Tambah Data Master Supplier Baru</h2>

    <form method="POST">
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Nama" required>
        <br>

        <label>Telp</label>
        <input type="text" name="telp" placeholder="telp" required>
        <br>

        <label>Alamat</label>
        <input type="text" name="alamat" placeholder="alamat" required>
        <br>

        <button type="submit" name="simpan" class="simpan">
            Simpan
        </button>

        <a href="index.php" class="batal">Batal</a>
    </form>

</body>
</html>