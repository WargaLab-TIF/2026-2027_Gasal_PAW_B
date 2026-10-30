<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $nama   = $_POST['nama'];
    $telp   = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $stmt = mysqli_prepare($koneksi, "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Master Supplier Baru</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 style="color:#337ab7;margin-top:20px;">Tambah Data Master Supplier Baru</h2>
    <hr>
    <form method="post" class="form-horizontal" style="margin-top:30px;">
        <div class="form-group">
            <label class="col-sm-4 control-label">Nama</label>
            <div class="col-sm-5">
                <input type="text" name="nama" class="form-control" placeholder="Nama" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Telp</label>
            <div class="col-sm-4">
                <input type="text" name="telp" class="form-control" placeholder="telp" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Alamat</label>
            <div class="col-sm-4">
                <input type="text" name="alamat" class="form-control" placeholder="alamat" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-6">
                <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                <a href="index.php" class="btn btn-danger">Batal</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>