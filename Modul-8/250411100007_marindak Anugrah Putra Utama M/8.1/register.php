<?php
session_start();
require "koneksi.php";

if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

$error = '';
if (isset($_POST['tombol_daftar'])) {
    $nama = trim($_POST['name'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (mysqli_fetch_row(mysqli_execute_query($connect, "SELECT 1 FROM user WHERE username = ?", [$username]))) {
        $error = 'Username sudah dipakai';
    } else {
        // level 2 (kasir); md5 sama seperti login.php
        mysqli_execute_query($connect, "INSERT INTO user (name, username, password, level) VALUES (?, ?, ?, 2)", [$nama, $username, md5($password)]);
        echo "<script>alert('daftar berhasil'); window.location='login.php' </script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Daftar Akun</title></head>
<body>
    <h3>Registrasi</h3>
    <?php if ($error): ?><p style="color:red"><?= $error ?></p><?php endif ?>
    <form action="" method="post">
        <input type="text" name="name" placeholder="name" required><br><br>
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="submit" name="tombol_daftar" value="Daftar">
    </form>
    <a href="login.php">Batal / Login</a>
</body>
</html>
