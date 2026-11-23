<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $telp   = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO supplier (nama, telp, alamat)
              VALUES ('$nama', '$telp', '$alamat')";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php?pesan=Data berhasil ditambahkan");
        exit;
    } else {
        echo "Error: ".mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Supplier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
        }
        h2 {
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
        }
        .pesan {
            padding: 10px;
            margin-bottom: 20px;
            background-color: #e6f4ea;
            border: 1px solid #b7dfc3;
        }
        .tambah {
            display: inline-block;
            margin-bottom: 20px;
            padding: 9px 15px;
            background-color: #333;
            color: white;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        .edit {
            margin-right: 10px;
        }
        .hapus {
            color: red;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            padding: 8px;
            width: 300px;
            margin-bottom: 15px;
        }
        button {
            padding: 8px 15px;
            cursor: pointer;
        }
        .batal {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Data Master Supplier Baru</h2>
        <form method="post">
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Nama" required>
            <label>Telp</label>
            <input type="text" name="telp" placeholder="Telp" required>
            <label>Alamat</label>
            <input type="text" name="alamat" placeholder="Alamat" required>
            <button type="submit" name="simpan">Simpan</button>
            <a href="index.php" class="batal">Batal</a>
        </form>
    </div>
</body>
</html>