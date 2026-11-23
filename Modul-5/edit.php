<?php
include "koneksi.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid!");
}

$id = (int) $_GET['id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM supplier WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data supplier tidak ditemukan!");
}

if (isset($_POST['update'])) {

    $nama = trim($_POST['nama']);
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE supplier SET nama = ?, telp = ?, alamat = ? WHERE id = ?"
    );

    mysqli_stmt_bind_param($stmt, "sssi", $nama, $telp, $alamat, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal mengubah data!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h2>EDIT DATA SUPPLIER</h2>

    <form method="POST">

        <label>Nama Supplier</label>
        <input type="text" name="nama"
               value="<?= htmlspecialchars($data['nama']); ?>" required>

        <label>Nomor Telepon</label>
        <input type="text" name="telp"
               value="<?= htmlspecialchars($data['telp']); ?>" required>

        <label>Alamat</label>
        <textarea name="alamat" required><?= htmlspecialchars($data['alamat']); ?></textarea>

        <button type="submit" name="update" class="btn edit">
            Update
        </button>

        <a href="index.php" class="btn kembali">Kembali</a>

    </form>

</div>

</body>
</html>