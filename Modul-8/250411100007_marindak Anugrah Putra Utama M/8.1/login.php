<?php
session_start();
require 'koneksi.php';

if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

$error = '';
if (isset($_POST['tombol_login'])) {
    $username = trim($_POST['username'] ?? '');
    $row = mysqli_fetch_assoc(mysqli_execute_query($connect, "SELECT * FROM user WHERE username = ?", [$username]));

    // Password pada SQL adalah MD5 dari nama akun (sesuai data akun awal).
    if (!$row || !hash_equals($row['password'], md5($_POST['password'] ?? ''))) {
        $error = 'Username atau password salah';
    } else {
        session_regenerate_id(true);
        $_SESSION['login'] = true;
        $_SESSION['username'] = $row['username'];
        $_SESSION['nama'] = $row['name'];
        $_SESSION['level'] = $row['level'];
        $_SESSION['id_user'] = $row['id_user'];
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Login</title>
</head>
<body>
    <h3>Silakan Login</h3>
    <?php if ($error): ?><p style="color:red"><?= $error ?></p><?php endif ?>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="submit" name="tombol_login" value="Login Masuk">
    </form>
    <br>
    <a href="register.php">Daftar Akun</a>
</body>
</html>
