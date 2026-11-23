
<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama = trim($_POST['nama']);
    $tlp = trim($_POST['tlp']);
    $alamat = trim($_POST['alamat']);

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO suplier (nama, tlp, alamat)
         VALUES (?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt, "sss", $nama, $tlp, $alamat
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    }

    echo "Gagal menambahkan data.";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 30px;
        }
        h2 {
            font-size: 24px;
            font-weight: normal;
            color: #568da5;
            margin: 0 0 18px 0;
            padding-bottom: 12px;
            border-bottom: 1px solid #eee;
        }
        form {
            width: 430px;
            margin-left: 70px;
        }

        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        label {
            width: 70px;
            text-align: right;
            margin-right: 15px;
            font-weight: bold;
            color: #555;
        }
        input {
            width: 250px;
            padding: 6px 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            height: 27px;
            box-sizing: border-box;
            font-size: 12px;
        }
        input:focus {
            outline: none;
            border-color: #66afe9;
            box-shadow: 0 0 5px rgba(102, 175, 233, .5);
        }
        .tombol {
            margin-left: 85px;
            margin-top: 2px;
        }
        button, .btn-batal {
            display: inline-block;
            padding: 7px 11px;
            border: 1px solid transparent;
            border-radius: 4px;
            color: white;
            font-size: 12px;
            text-decoration: none;
            cursor: pointer;
        }
        .btn-simpan {
            background: #75ad45;
            border-color: #649b37;
        }
        .btn-update {
            background: #75ad45;
            border-color: #649b37;
        }
        .btn-batal {
            background: #c82333;
            border-color: #bd2130;
        }
        .btn-simpan:hover,
        .btn-update:hover {
            background: #63963a;
        }
        .btn-batal:hover {
            background: #a71d2a;
        }
    </style>
</head>
<body>
<h2>Tambah Data Master Supplier Baru</h2>
<form method="POST">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama"
               placeholder="Nama" required>
    </div>
    <div class="form-group">
        <label>Telp</label>
        <input type="text" name="tlp"
               placeholder="telp" maxlength="12" required>
    </div>
    <div class="form-group">
        <label>Alamat</label>
        <input type="text" name="alamat"
               placeholder="alamat" maxlength="50">
    </div>
    <div class="tombol">
        <button type="submit" name="simpan" class="btn-simpan">
            Simpan
        </button>

        <a href="index.php" class="btn-batal">Batal</a>
    </div>
</form>
</body>
</html>
