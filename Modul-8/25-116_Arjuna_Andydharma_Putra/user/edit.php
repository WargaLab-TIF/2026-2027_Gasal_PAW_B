<?php
include '../koneksi.php';
cek_login();
if ($_SESSION['level'] != 1) {
    echo "<script>alert('Akses ditolak!'); window.location='../index.php';</script>";
    exit;
}

$id = (int)$_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user=$id"));
if (!$data) { header("Location: index.php"); exit; }

if (isset($_POST['update'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $hp = mysqli_real_escape_string($conn, $_POST['hp']);
    $level = (int)$_POST['level'];

    $q = "UPDATE user SET username='$username', password='$password', nama='$nama', alamat='$alamat', hp='$hp', level=$level WHERE id_user=$id";
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
    <title>Edit User</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f6fa; }
        .container { padding: 20px 30px; max-width: 500px; }
        form { background: white; padding: 25px; border-radius: 8px; }
        label { display: block; margin-top: 12px; }
        input, select { width: 100%; padding: 8px; margin-top: 4px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { margin-top: 20px; padding: 10px 20px; background: #3498db; color: white; border: none; border-radius: 4px; cursor: pointer; }
        a { display: inline-block; margin-top: 15px; color: #3498db; }
    </style>
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="container">
        <h2>Edit User</h2>
        <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="post">
            <label>Username</label>
            <input type="text" name="username" value="<?= htmlspecialchars($data['username']) ?>" required>
            <label>Password</label>
            <input type="text" name="password" value="<?= htmlspecialchars($data['password']) ?>" required>
            <label>Nama</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
            <label>Alamat</label>
            <input type="text" name="alamat" value="<?= htmlspecialchars($data['alamat']) ?>">
            <label>HP</label>
            <input type="text" name="hp" value="<?= htmlspecialchars($data['hp']) ?>">
            <label>Level</label>
            <select name="level" required>
                <option value="1" <?= $data['level']==1?'selected':'' ?>>1 - Owner</option>
                <option value="2" <?= $data['level']==2?'selected':'' ?>>2 - Kasir</option>
            </select>
            <button type="submit" name="update">Update</button>
        </form>
        <a href="index.php">← Kembali</a>
    </div>
</body>
</html>
