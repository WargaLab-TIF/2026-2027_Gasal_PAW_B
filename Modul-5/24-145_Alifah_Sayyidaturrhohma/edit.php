
<?php
$conn = mysqli_connect("localhost", "root", "", "modul5");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (!isset($_GET['id'])) {
    die("ID supplier tidak ditemukan!");
}

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM supplier WHERE id=$id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data supplier tidak ditemukan!");
}

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $stmt = mysqli_prepare($conn,
        "UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id=?");

    mysqli_stmt_bind_param($stmt, "sssi", $nama, $telp, $alamat, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: soal-1.php");
        exit;
    } else {
        echo "Gagal mengubah data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Edit Data Master Supplier</h2>

<form method="POST">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama"
               value="<?php echo htmlspecialchars($data['nama']); ?>" required>
    </div>

    <div class="form-group">
        <label>Telp</label>
        <input type="text" name="telp"
               value="<?php echo htmlspecialchars($data['telp']); ?>" required>
    </div>

    <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" required><?php echo htmlspecialchars($data['alamat']); ?></textarea>
    </div>

    <button type="submit" name="update" class="simpan">Update</button>
    <a href="soal-1.php" class="batal">Batal</a>
</form>

</body>
</html>
