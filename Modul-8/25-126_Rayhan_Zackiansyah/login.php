<?php
include 'koneksi.php';

if (isset($_SESSION['login'])) {
  header('Location: index.php');
  exit;
}

$pesan = '';

if (isset($_POST['login'])) {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  $stmt = mysqli_prepare($conn, 'SELECT * FROM user WHERE username = ?');
  mysqli_stmt_bind_param($stmt, 's', $username);
  mysqli_stmt_execute($stmt);
  $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

  if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);

    $_SESSION['login'] = true;
    $_SESSION['id_user'] = $user['id_user'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['level'] = $user['level'];

    header('Location: index.php');
    exit;
  } else {
    $pesan = 'Username atau password salah.';
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Penjualan</title>
  <link rel="stylesheet" href="style.css">
</head>
<body class="halaman-login">

<div class="login-box">
  <h2>Login Penjualan</h2>
  <p>Masukkan username dan password.</p>

  <?php if ($pesan != '') { ?>
    <p class="pesan"><?= htmlspecialchars($pesan); ?></p>
  <?php } ?>

  <form method="post">
    <label>Username</label>
    <input type="text" name="username" placeholder="Username" required autofocus>

    <label>Password</label>
    <input type="password" name="password" placeholder="Password" required>

    <button type="submit" name="login">Login</button>
  </form>

  <p>Petunjuk</p>
  <p>username: admin</p>
  <p>password: admin123</p>

  <br>

  <p>username: kasir</p>
  <p>password: kasir123</p>
</div>

</body>
</html>