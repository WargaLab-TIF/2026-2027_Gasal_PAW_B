<?php
$conn = mysqli_connect("localhost", "root", "", "modul5");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $stmt = mysqli_prepare($conn,
        "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)");

    mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: soal-1.php");
        exit;
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Tambah Data Master Supplier Baru</h2>

<form method="POST">
    <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama" placeholder="Nama" required>
    </div>

    <div class="form-group">
        <label>Telp</label>
        <input type="text" name="telp" placeholder="telp" required>
    </div>

    <div class="form-group">
        <label>Alamat</label>
        <textarea name="alamat" placeholder="alamat" required></textarea>
    </div>

    <button type="submit" name="simpan" class="simpan">Simpan</button>
    <a href="soal-1.php" class="batal">Batal</a>
</form>

</body>
</html>
