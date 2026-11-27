<?php
session_start();
require "koneksi.php";

// jika sudah login, tidak boleh membuka halaman login
if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

$error = "";

if (isset($_POST['tombol_login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // validasi input
    if ($username === "" || $password === "") {
        $error = "Username dan password wajib diisi";
    } else {
        $stmt = mysqli_prepare($connect, "SELECT * FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (md5($password) == $row['password']) {
                // set session
                $_SESSION['login'] = true;
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['nama'] = $row['nama'];
                $_SESSION['level'] = $row['level'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Password salah";
            }
        } else {
            $error = "Username tidak ditemukan";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Halaman Login</title>
</head>
<body>
    <h3>Silakan Login</h3>
    <?php if ($error != "") { ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php } ?>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"><br><br>
        <input type="password" name="password" placeholder="Password"><br><br>
        <input type="submit" name="tombol_login" value="Login">
    </form>
</body>
</html>
