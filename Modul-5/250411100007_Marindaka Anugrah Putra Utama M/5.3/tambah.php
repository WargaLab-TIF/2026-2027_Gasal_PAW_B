<?php
include "koneksi.php";
$nama = $telp = $alamat = $pesan = "";

if (isset($_POST["simpan"])) {
  $nama   = $_POST["nama"];
  $telp   = $_POST["telp"];
  $alamat = $_POST["alamat"];

  if (!preg_match("/^[0-9]+$/", $telp)) {
    $pesan = "Telp hanya boleh angka!";
  } else {
    mysqli_query($conn, "INSERT INTO supplier (nama, telp, alamat)
                         VALUES ('" . addslashes($nama) . "', '$telp', '" . addslashes($alamat) . "')");
    header("Location: index.php");
    exit;
  }
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
<div class="container">
  <h2>Tambah Data Master Supplier Baru</h2>
  <hr>
  <p class="text-danger"><?php echo $pesan; ?></p>
  <form method="post" class="form-horizontal">
    <div class="form-group"><label class="col-sm-4 control-label">Nama</label>
      <div class="col-sm-5"><input type="text" name="nama" class="form-control" placeholder="Nama" value="<?php echo htmlspecialchars($nama); ?>" required></div></div>
    <div class="form-group"><label class="col-sm-4 control-label">Telp</label>
      <div class="col-sm-3"><input type="text" name="telp" class="form-control" placeholder="telp" value="<?php echo htmlspecialchars($telp); ?>" required></div></div>
    <div class="form-group"><label class="col-sm-4 control-label">Alamat</label>
      <div class="col-sm-3"><input type="text" name="alamat" class="form-control" placeholder="alamat" value="<?php echo htmlspecialchars($alamat); ?>" required></div></div>
    <div class="form-group"><div class="col-sm-offset-4 col-sm-5">
      <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
      <a href="index.php" class="btn btn-danger">Batal</a></div></div>
  </form>
</div>
