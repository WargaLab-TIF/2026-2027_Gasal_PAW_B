<?php
include "koneksi.php";

$id = $_GET["id"];

if (isset($_POST["update"])) {
  $nama = $_POST["nama"];
  $telp = $_POST["telp"];
  $alamat = $_POST["alamat"];

  $query = "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id=$id";

  if (mysqli_query($conn, $query)) {
    header("Location: index.php");
  } else {
    echo "Error: " . mysqli_error($conn);
  }
}

$query = "SELECT * FROM supplier WHERE id=$id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Data Master Supplier</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

  <div class="header">
    <h2>Edit Data Master Supplier</h2>
  </div>

  <form method="post">
    <div class="form-baris">
      <label>Nama</label>
      <input type="text" name="nama" value="<?php echo $row["nama"]; ?>" required>
    </div>
    <div class="form-baris">
      <label>Telp</label>
      <input type="text" name="telp" value="<?php echo $row["telp"]; ?>" required>
    </div>
    <div class="form-baris">
      <label>Alamat</label>
      <input type="text" name="alamat" value="<?php echo $row["alamat"]; ?>" required>
    </div>
    <div class="form-tombol">
      <button type="submit" name="update" class="btn btn-simpan">Update</button>
      <a href="index.php" class="btn btn-batal">Batal</a>
    </div>
  </form>

</div>
</body>
</html>