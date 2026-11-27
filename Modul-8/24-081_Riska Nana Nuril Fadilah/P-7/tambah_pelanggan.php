<?php
require 'koneksi.php';

if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat)
              VALUES ('$id', '$nama', '$jenis_kelamin', '$telp', '$alamat')";

    if (mysqli_query($conn, $query)) {
        header("Location: pelanggan.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Pelanggan</title>

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
            width: 120px;
            margin-bottom: 15px;
        }

        input, select {
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

    <h2>Tambah Data Pelanggan</h2>

    <form method="POST">

        <label>ID Pelanggan</label>
        <input type="text" name="id" placeholder="Contoh: PLG006" required>
        <br>

        <label>Nama</label>
        <input type="text" name="nama" required>
        <br>

        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" required>
            <option value="">-- Pilih --</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select>
        <br>

        <label>Telepon</label>
        <input type="text" name="telp" required>
        <br>

        <label>Alamat</label>
        <input type="text" name="alamat" required>
        <br><br>

        <button type="submit" name="simpan" class="simpan">
            Simpan
        </button>

        <a href="pelanggan.php" class="batal">Batal</a>

    </form>

</body>
</html>