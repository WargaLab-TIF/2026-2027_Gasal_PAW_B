<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "koneksi.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tombol_login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Username dan password wajib diisi.";
    } else {
        $stmt = mysqli_prepare($koneksi, "SELECT id_user, username, password, nama, level FROM user WHERE username = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            if ($password === $row['password']) {
                $level = (int)$row['level'];
                if ($level !== 1 && $level !== 2) {
                    $error = "Level user tidak diizinkan untuk login.";
                } else {
                    $_SESSION['login']    = true;
                    $_SESSION['id_user']  = $row['id_user'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['nama']     = $row['nama'];
                    $_SESSION['level']    = $level;

                    header("Location: index.php");
                    exit();
                }
            } else {
                $error = "Password salah.";
            }
        } else {
            $error = "Username tidak ditemukan.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Aplikasi Penjualan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="login-wrap">
    <h2>Login Sistem Penjualan</h2>
    <?php if ($error !== "") { ?>
        <div class="msg"><?= htmlspecialchars($error) ?></div>
    <?php } ?>

    <form method="post" action="">
        <label for="username">Username</label>
        <input id="username" type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" placeholder="Masukkan username" required autofocus>

        <label for="password">Password</label>
        <input id="password" type="password" name="password" placeholder="Masukkan password" required>

        <button class="btn" type="submit" name="tombol_login" style="width: 100%; margin: 6px 0 0;">Login</button>
    </form>
</div>
</body>
</html>
