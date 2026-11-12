<?php
include "koneksi.php";
$pesan = "";

if (isset($_POST["update"])) {
  $id     = (int) $_POST["id"];
  $nama   = $_POST["nama"];
  $telp   = $_POST["telp"];
  $alamat = $_POST["alamat"];

  if (!preg_match("/^[0-9]+$/", $telp)) {
    $pesan = "Telp hanya boleh angka!";
  } else {
    mysqli_query($conn, "UPDATE supplier SET nama='" . addslashes($nama) . "', telp='$telp',
                         alamat='" . addslashes($alamat) . "' WHERE id=$id");
    header("Location: index.php");
    exit;
  }
} else {
  $id = (int) $_GET["id"];
  $result = mysqli_query($conn, "SELECT * FROM supplier WHERE id=$id");
  $row = mysqli_fetch_assoc($result);
  $nama = $row["nama"];
  $telp = $row["telp"];
  $alamat = $row["alamat"];
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
<div class="container">
  <h2>Edit Data Master Supplier</h2>
  <hr>
  <p class="text-danger"><?php echo $pesan; ?></p>
  <form method="post" class="form-horizontal">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="form-group"><label class="col-sm-4 control-label">Nama</label>
      <div class="col-sm-5"><input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($nama); ?>" required></div></div>
    <div class="form-group"><label class="col-sm-4 control-label">Telp</label>
      <div class="col-sm-3"><input type="text" name="telp" class="form-control" value="<?php echo htmlspecialchars($telp); ?>" required></div></div>
    <div class="form-group"><label class="col-sm-4 control-label">Alamat</label>
      <div class="col-sm-3"><input type="text" name="alamat" class="form-control" value="<?php echo htmlspecialchars($alamat); ?>" required></div></div>
    <div class="form-group"><div class="col-sm-offset-4 col-sm-5">
      <button type="submit" name="update" class="btn btn-success">Update</button>
      <a href="index.php" class="btn btn-danger">Batal</a></div></div>
  </form>
</div>
