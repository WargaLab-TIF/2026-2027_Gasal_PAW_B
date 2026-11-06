<?php
include 'koneksi.php';

$id = (int) $_GET['id'];

if (isset($_POST['update'])) {
    $nama   = trim($_POST['nama']);
    $telp   = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    $stmt = mysqli_prepare($conn, "UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssi", $nama, $telp, $alamat, $id);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

$stmt = mysqli_prepare($conn, "SELECT nama, telp, alamat FROM supplier WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$data) {
    die("Data tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Data Master Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Edit Data Master Supplier</h2>
    <form method="POST" class="form">
        <label>Nama</label>
        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>

        <label>Telp</label>
        <input type="text" name="telp" value="<?= htmlspecialchars($data['telp']) ?>" required>

        <label>Alamat</label>
        <input type="text" name="alamat" value="<?= htmlspecialchars($data['alamat']) ?>" required>

        <button type="submit" name="update" class="btn btn-hijau">Update</button>
        <a href="index.php" class="btn btn-merah">Batal</a>
    </form>
</div>
</body>
</html>
