<?php
include "koneksi.php";

$id = $_GET["id"];

if (isset($_POST["update"])) {
    $nama = $_POST["nama"];
    $telp = $_POST["telp"];
    $alamat = $_POST["alamat"];

    $sql = "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

$sql = "SELECT id, nama, telp, alamat FROM supplier WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Master Supplier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        h2 { color: #337ab7; font-family: Arial, sans-serif; }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Data Master Supplier</h2>
    <hr>
    <form class="form-horizontal" method="post" action="edit.php?id=<?php echo $id; ?>">
        <div class="form-group">
            <label class="col-sm-4 control-label">Nama</label>
            <div class="col-sm-4">
                <input type="text" name="nama" class="form-control" value="<?php echo $row["nama"]; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Telp</label>
            <div class="col-sm-3">
                <input type="text" name="telp" class="form-control" value="<?php echo $row["telp"]; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Alamat</label>
            <div class="col-sm-3">
                <input type="text" name="alamat" class="form-control" value="<?php echo $row["alamat"]; ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                <button type="submit" name="update" class="btn btn-success">Update</button>
                <a href="index.php" class="btn btn-danger">Batal</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>
