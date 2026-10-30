<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {

    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = mysqli_query($conn, "INSERT INTO supplier
        (nama, telp, alamat)
        VALUES ('$nama', '$telp', '$alamat')");

    if ($query) {
        header("Location: index.php");
        exit;
    } else {
        echo "Data gagal disimpan";
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
            margin: 30px;
        }

        h2 {
            color: cadetblue;
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
            background-color: mediumseagreen;
        }

        .batal {
            background-color: firebrick;
        }
    </style>
</head>
<body>

    <div class="container">

        <h2>Tambah Data Master Supplier Baru</h2>

        <form method="POST">

            <div class="form-group">
                <label>Nama</label>
                <input class="nama" type="text" name="nama"
                placeholder="Nama" required>
            </div>

            <div class="form-group">
                <label>Telp</label>
                <input type="text" name="telp"
                placeholder="telp" required>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat"
                placeholder="alamat" required>
            </div>

            <div class="form-actions">
                <button type="submit" class ="simpan" name="simpan">Simpan</button>
                <a href="index.php" class="batal">Batal</a>
            </div>

        </form>

    </div>

</body>
</html>