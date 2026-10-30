<?php
include "koneksi.php";

if (isset($_POST["simpan"])) {
    $nama = $_POST["nama"];
    $telp = $_POST["telp"];
    $alamat = $_POST["alamat"];

    $sql = "INSERT INTO supplier (nama, telp, alamat)
    VALUES ('$nama', '$telp', '$alamat')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Master Supplier Baru</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        h2 { color: #337ab7; font-family: Arial, sans-serif; }
    </style>
</head>
<body>
<div class="container">
    <h2>Tambah Data Master Supplier Baru</h2>
    <hr>
    <form class="form-horizontal" method="post" action="tambah.php">
        <div class="form-group">
            <label class="col-sm-4 control-label">Nama</label>
            <div class="col-sm-4">
                <input type="text" name="nama" class="form-control" placeholder="Nama">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Telp</label>
            <div class="col-sm-3">
                <input type="text" name="telp" class="form-control" placeholder="telp">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Alamat</label>
            <div class="col-sm-3">
                <input type="text" name="alamat" class="form-control" placeholder="alamat">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                <a href="index.php" class="btn btn-danger">Batal</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>
