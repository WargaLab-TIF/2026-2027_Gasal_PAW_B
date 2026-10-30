<?php
include "koneksi.php";

$id = (int) ($_GET['id'] ?? 0);

if (isset($_POST['update'])) {
    $nama   = $_POST['nama'];
    $telp   = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $stmt = mysqli_prepare($koneksi, "UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id_supplier=?");
    mysqli_stmt_bind_param($stmt, "sssi", $nama, $telp, $alamat, $id);
    mysqli_stmt_execute($stmt);

    header("Location: index.php");
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT * FROM supplier WHERE id_supplier=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    die("Data tidak ditemukan. <a href='index.php'>Kembali</a>");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Master Supplier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 style="color:#337ab7;margin-top:20px;">Edit Data Master Supplier</h2>
    <hr>
    <form method="post" class="form-horizontal" style="margin-top:30px;">
        <div class="form-group">
            <label class="col-sm-4 control-label">Nama</label>
            <div class="col-sm-5">
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Telp</label>
            <div class="col-sm-4">
                <input type="text" name="telp" class="form-control" value="<?= htmlspecialchars($data['telp']); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Alamat</label>
            <div class="col-sm-4">
                <input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($data['alamat']); ?>" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-6">
                <button type="submit" name="update" class="btn btn-success">Update</button>
                <a href="index.php" class="btn btn-danger">Batal</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>