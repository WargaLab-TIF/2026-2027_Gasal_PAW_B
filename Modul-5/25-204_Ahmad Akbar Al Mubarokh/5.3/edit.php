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

$query = "SELECT id, nama, telp, alamat FROM supplier WHERE id=$id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Data Master Supplier</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
  <div class="page-header">
    <h2 style="color:#337ab7;">Edit Data Master Supplier</h2>
  </div>

  <form method="post" class="form-horizontal">
    <div class="form-group">
      <label class="col-sm-3 control-label">Nama</label>
      <div class="col-sm-5">
        <input type="text" name="nama" class="form-control" value="<?php echo $row["nama"]; ?>" required>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Telp</label>
      <div class="col-sm-3">
        <input type="text" name="telp" class="form-control" value="<?php echo $row["telp"]; ?>" required>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label">Alamat</label>
      <div class="col-sm-3">
        <input type="text" name="alamat" class="form-control" value="<?php echo $row["alamat"]; ?>" required>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-3 col-sm-5">
        <button type="submit" name="update" class="btn btn-success">Update</button>
        <a href="index.php" class="btn btn-danger">Batal</a>
      </div>
    </div>
  </form>
</div>
</body>
</html>
