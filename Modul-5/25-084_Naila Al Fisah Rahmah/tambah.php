
<?php
require 'koneksi.php';

mysqli_select_db($conn, "Modul 5");

if (isset($_POST['simpan'])) {

    $Nama = $_POST['Nama'];
    $Telp = $_POST['Telp'];
    $Alamat = $_POST['Alamat'];

    $query = "INSERT INTO dataMaster (Nama, Telp, Alamat)
              VALUES ('$Nama', '$Telp', '$Alamat')";

    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
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
            color: #333;
        }

        h2 {
            color: #5790a5;
            font-size: 24px;
            font-weight: normal;
            border-bottom: 1px solid #ddd;
            padding-bottom: 12px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }

        input {
            width: 350px;
            padding: 9px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            padding: 9px 13px;
            border: none;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 13px;
        }

        .simpan {
            background-color: #70ad47;
        }

        .batal {
            background-color: #c82333;
        }
    </style>
</head>

<body>

    <h2>Tambah Data Master Supplier Baru</h2>

    <form method="POST">

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="Nama" placeholder="Nama" required>
        </div>

        <div class="form-group">
            <label>Telp</label>
            <input type="text" name="Telp" placeholder="Telp" required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="Alamat" placeholder="Alamat">
        </div>

        <div class="form-group">
            <label></label>
            <button type="submit" name="simpan" class="btn simpan">
                Simpan
            </button>

            <a href="index.php" class="btn batal">Batal</a>
        </div>

    </form>

</body>
</html>
