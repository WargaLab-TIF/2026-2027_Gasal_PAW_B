<?php
include "koneksi.php";

if (isset($_POST["update"])) {
    $id     = (int) $_POST["id"];
    $nama   = $_POST["nama"];
    $telp   = $_POST["telp"];
    $alamat = $_POST["alamat"];

    $stmt = $conn->prepare("UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id=?");
    $stmt->bind_param("sssi", $nama, $telp, $alamat, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}

$id     = (int) $_GET["id"];
$result = mysqli_query($conn, "SELECT id, nama, telp, alamat FROM supplier WHERE id=$id");
$row    = mysqli_fetch_assoc($result);

if (!$row) {
    die("Data tidak ditemukan");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Master Supplier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="text-primary">Edit Data Master Supplier</h2>
    <hr>
    <form class="form-horizontal" method="post" action="edit.php?id=<?= $row["id"] ?>">
        <input type="hidden" name="id" value="<?= $row["id"] ?>">
        <div class="form-group">
            <label class="col-sm-4 control-label">Nama</label>
            <div class="col-sm-5"><input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row["nama"]) ?>" required></div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Telp</label>
            <div class="col-sm-3"><input type="text" name="telp" class="form-control" value="<?= htmlspecialchars($row["telp"]) ?>" required></div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Alamat</label>
            <div class="col-sm-3"><input type="text" name="alamat" class="form-control" value="<?= htmlspecialchars($row["alamat"]) ?>" required></div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-5">
                <button type="submit" name="update" class="btn btn-success">Update</button>
                <a href="index.php" class="btn btn-danger">Batal</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>
