<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {

    $nama = trim($_POST['nama']);
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)"
    );

    mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h2>TAMBAH DATA SUPPLIER</h2>

    <form method="POST">

        <label>Nama Supplier</label>
        <input type="text" name="nama" required>

        <label>Nomor Telepon</label>
        <input type="text" name="telp" required>

        <label>Alamat</label>
        <textarea name="alamat" required></textarea>

        <button type="submit" name="simpan" class="btn tambah">
            Simpan
        </button>

        <a href="index.php" class="btn kembali">Kembali</a>

    </form>

</div>

</body>
</html>
