<?php
include "koneksi.php";

if (isset($_POST["simpan"])) {
  $nama = $_POST["nama"];
  $telp = $_POST["telp"];
  $alamat = $_POST["alamat"];

  $query = "INSERT INTO supplier (nama, telp, alamat)
  VALUES ('$nama', '$telp', '$alamat')";

  if (mysqli_query($conn, $query)) {
    header("Location: index.php");
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Tambah Data Master Supplier Baru</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
  <div class="page-header">
    <h2 style="color:#337ab7;">Tambah Data Master Supplier Baru</h2>
  </div>

  <form method="post" class="form-horizontal">
    <div class="form-group">
      <label class="col-sm-3 control-label">Nama</label>
      <div class="col-sm-5">
        <input type="text" name="nama" class="form-control" placeholder="Nama" required>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Telp</label>
      <div class="col-sm-3">
        <input type="text" name="telp" class="form-control" placeholder="telp" required>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Alamat</label>
      <div class="col-sm-3">
        <input type="text" name="alamat" class="form-control" placeholder="alamat" required>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-3 col-sm-5">
        <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-danger">Batal</a>
      </div>
    </div>
  </form>
</div>
</body>
</html>
