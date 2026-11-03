<?php
include 'koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$query = "SELECT * FROM supplier WHERE id=$id";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data supplier tidak ditemukan.");
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE supplier
              SET nama=?, telp=?, alamat=?
              WHERE id=?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssi", $nama, $telp, $alamat, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Data berhasil diupdate!');
                window.location='index.php';
              </script>";
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Edit Data Master Supplier</h2>
    <hr>

    <form method="POST" action="">
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama"
                   value="<?php echo htmlspecialchars($data['nama']); ?>"
                   required>
        </div>

        <div class="form-group">
            <label>Telp</label>
            <input type="text" name="telp"
                   value="<?php echo htmlspecialchars($data['telp']); ?>"
                   required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <input type="text" name="alamat"
                   value="<?php echo htmlspecialchars($data['alamat']); ?>"
                   required>
        </div>

        <div class="form-button">
            <button type="submit" name="update"
                    class="btn simpan">Update</button>

            <a href="index.php" class="btn hapus">
                Batal
            </a>
        </div>
    </form>
</div>

</body>
</html>