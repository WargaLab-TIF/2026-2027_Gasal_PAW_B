<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['Nama']);
    $telp = mysqli_real_escape_string($koneksi, $_POST['Telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['Alamat']);

    $query = mysqli_query($koneksi, "INSERT INTO master_suppiler (Nama, Telp, Alamat)
              VALUES ('$nama', '$telp', '$alamat')");

    if ($query) {
        header("Location: data_baru.php");
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Master Suppiler</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 25px;
            color: #555;
        }

        h2 {
            color: #39758d;
            font-size: 24px;
            font-weight: normal;
            border-bottom: 1px solid #ddd;
            padding-bottom: 12px;
        }

        .form {
            width: 500px;
            margin: 30px auto;
        }

        .baris {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        label {
            width: 130px;
            text-align: right;
            margin-right: 20px;
            font-weight: bold;
        }

        input, textarea {
            width: 270px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: Arial;
        }

        .simpan {
            margin-left: 150px;
            background: #75ad43;
            color: white;
            border: none;
            padding: 9px 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .batal {
            background: #c82333;
            color: white;
            padding: 9px 15px;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<h2>Tambah Data Master Supplier</h2>

<form method="POST" class="form">

    <div class="baris">
        <label>Nama</label>
        <input type="text" name="Nama" required placeholder="Nama">
    </div>

    <div class="baris">
        <label>Telp</label>
        <input type="text" name="Telp" required placeholder="Telp">
    </div>

    <div class="baris">
        <label>Alamat</label>
        <input type="text" name="Alamat" required placeholder="Alamat">
    </div>

    <button type="submit" name="simpan" class="simpan">Simpan</button>
    <a href="data_baru.php" class="batal">Batal</a>

</form>

</body>
</html>
