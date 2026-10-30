<?php
include "koneksi.php";

if (isset($_POST["simpan"])) {
  $nama = $_POST["nama"];
  $telp = $_POST["telp"];
  $alamat = $_POST["alamat"];

  $query = "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama', '$telp', '$alamat')";

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
  <title>Tambah Data Master Supplier</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

  <div class="header">
    <h2>Tambah Data Master Supplier Baru</h2>
  </div>

  <form method="post">
    <div class="form-baris">
      <label>Nama</label>
      <input type="text" name="nama" placeholder="Nama" required>
    </div>
    <div class="form-baris">
      <label>Telp</label>
      <input type="text" name="telp" placeholder="telp" required>
    </div>
    <div class="form-baris">
      <label>Alamat</label>
      <input type="text" name="alamat" placeholder="alamat" required>
    </div>
    <div class="form-tombol">
      <button type="submit" name="simpan" class="btn btn-simpan">Simpan</button>
      <a href="index.php" class="btn btn-batal">Batal</a>
    </div>
  </form>

</div>
</body>
</html>