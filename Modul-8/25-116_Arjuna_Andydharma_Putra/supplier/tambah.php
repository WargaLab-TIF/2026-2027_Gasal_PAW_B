<?php
include '../koneksi.php';
cek_login();
if ($_SESSION['level'] != 1) {
    echo "<script>alert('Akses ditolak!'); window.location='../index.php';</script>";
    exit;
}

if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $q = "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama', '$telp', '$alamat')";
    if (mysqli_query($conn, $q)) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Gagal: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Supplier</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f6fa; }
        .container { padding: 20px 30px; max-width: 500px; }
        form { background: white; padding: 25px; border-radius: 8px; }
        label { display: block; margin-top: 12px; }
        input, textarea { width: 100%; padding: 8px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { margin-top: 20px; padding: 10px 20px; background: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { display: inline-block; margin-top: 15px; color: #3498db; }
    </style>
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="container">
        <h2>Tambah Supplier</h2>
        <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="post">
            <label>Nama</label>
            <input type="text" name="nama" required>
            <label>Telp</label>
            <input type="text" name="telp">
            <label>Alamat</label>
            <textarea name="alamat" rows="3"></textarea>
            <button type="submit" name="simpan">Simpan</button>
        </form>
        <a href="index.php">← Kembali</a>
    </div>
</body>
</html>
