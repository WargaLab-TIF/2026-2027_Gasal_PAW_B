<?php
include 'koneksi.php';

if (isset($_POST['simpan'])) {
    $nama   = trim($_POST['nama']);
    $telp   = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    $stmt = mysqli_prepare($conn, "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);
    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Master Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Tambah Data Master Supplier Baru</h2>
    <form method="POST" class="form">
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Nama" required>

        <label>Telp</label>
        <input type="text" name="telp" placeholder="telp" required>

        <label>Alamat</label>
        <input type="text" name="alamat" placeholder="alamat" required>

        <button type="submit" name="simpan" class="btn btn-hijau">Simpan</button>
        <a href="index.php" class="btn btn-merah">Batal</a>
    </form>
</div>
</body>
</html>
