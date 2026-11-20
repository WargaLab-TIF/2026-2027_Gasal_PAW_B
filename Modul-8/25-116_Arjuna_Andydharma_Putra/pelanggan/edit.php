<?php
include '../koneksi.php';
cek_login();
if ($_SESSION['level'] != 1) {
    echo "<script>alert('Akses ditolak!'); window.location='../index.php';</script>";
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pelanggan WHERE id='$id'"));
if (!$data) { header("Location: index.php"); exit; }

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jk = $_POST['jenis_kelamin'];
    $telp = mysqli_real_escape_string($conn, $_POST['telp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $q = "UPDATE pelanggan SET nama='$nama', jenis_kelamin='$jk', telp='$telp', alamat='$alamat' WHERE id='$id'";
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
    <title>Edit Pelanggan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f6fa; }
        .container { padding: 20px 30px; max-width: 500px; }
        form { background: white; padding: 25px; border-radius: 8px; }
        label { display: block; margin-top: 12px; }
        input, select, textarea { width: 100%; padding: 8px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { margin-top: 20px; padding: 10px 20px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { display: inline-block; margin-top: 15px; color: #3498db; }
    </style>
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="container">
        <h2>Edit Pelanggan</h2>
        <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="post">
            <label>ID Pelanggan</label>
            <input type="text" value="<?= htmlspecialchars($data['id']) ?>" disabled>
            <label>Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" required>
                <option value="L" <?= $data['jenis_kelamin']=='L'?'selected':'' ?>>Laki-laki</option>
                <option value="P" <?= $data['jenis_kelamin']=='P'?'selected':'' ?>>Perempuan</option>
            </select>
            <label>Telp</label>
            <input type="text" name="telp" value="<?= htmlspecialchars($data['telp']) ?>">
            <label>Alamat</label>
            <textarea name="alamat" rows="3"><?= htmlspecialchars($data['alamat']) ?></textarea>
            <button type="submit" name="update">Update</button>
        </form>
        <a href="index.php">← Kembali</a>
    </div>
</body>
</html>
