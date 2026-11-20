<?php
require_once "koneksi.php";
if (session_status() === PHP_SESSION_NONE) session_start();
if (isset($_SESSION['id_user']))  {
    header("Location: home.php");
    exit;
}
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST")  {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = mysqli_prepare($koneksi, "SELECT id_user, username, password, nama, level FROM user WHERE username=? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if ($user && md5($password) === $user['password'])  {
        session_regenerate_id(true);
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['level'] = (int)$user['level'];
        header("Location: home.php");
        exit;
    }  else $error = "Username atau password salah.";
}
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Login</title><link rel="stylesheet" href="style.css"></head><body>
<h1>Login Aplikasi Penjualan</h1>
<?php if ($error) echo '<p class="pesan">'.htmlspecialchars($error).'</p>';
?>
<form method="post">
<table><tr><td>Username</td><td><input type="text" name="username" required></td></tr>
<tr><td>Password</td><td><input type="password" name="password" required></td></tr>
<tr><td></td><td><input type="submit" value="Login"></td></tr></table>
</form>
</body></html>
