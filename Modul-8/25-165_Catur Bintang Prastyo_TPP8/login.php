<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: index.php");
    exit();
}

$pesan = "";
if (isset($_POST['tombol_login'])) {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']);

    $stmt = mysqli_prepare($connect, "SELECT * FROM user WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($password == $row['password']) {
            session_regenerate_id(true);
            $_SESSION['login']    = true;
            $_SESSION['id_user']  = $row['id_user'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama']     = $row['nama'];
            $_SESSION['level']    = $row['level'];
            header("Location: index.php");
            exit();
        } else {
            $pesan = "Password salah!";
        }
    } else {
        $pesan = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Halaman Login</title></head>
<body>
    <h3>Silakan Login</h3>
    <?php if ($pesan != "") { echo "<p style='color:red'>$pesan</p>"; } ?>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="submit" name="tombol_login" value="Login Masuk">
    </form>
</body>
</html>
