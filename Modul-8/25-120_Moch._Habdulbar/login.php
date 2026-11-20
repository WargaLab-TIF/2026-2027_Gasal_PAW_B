<?php
require 'config.php';

// Sudah login -> tidak boleh mengakses halaman login
if (isset($_SESSION['id_user'])) { header('Location: index.php'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $s = mysqli_prepare($conn, "SELECT id_user, username, nama, level FROM user WHERE username=? AND password=MD5(?)");
        mysqli_stmt_bind_param($s, 'ss', $username, $password);
        mysqli_stmt_execute($s);
        $u = mysqli_fetch_assoc(mysqli_stmt_get_result($s));

        if (!$u) {
            $error = 'Username atau password salah.';
        } elseif (!in_array($u['level'], [1, 2])) {
            $error = 'User ini tidak memiliki hak akses untuk login.';
        } else {
            session_regenerate_id(true);
            $_SESSION['id_user']  = $u['id_user'];
            $_SESSION['username'] = $u['username'];
            $_SESSION['nama']     = $u['nama'];
            $_SESSION['level']    = $u['level'];
            header('Location: index.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Login - Sistem Penjualan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body style="background:#eef2f7">
<div class="container">
  <div class="row" style="margin-top:100px">
    <div class="col-md-4 col-md-offset-4">
      <div class="panel panel-primary">
        <div class="panel-heading"><h4 class="panel-title">Login Sistem Penjualan</h4></div>
        <div class="panel-body">
          <?php if ($error) { ?><div class="alert alert-danger"><?= h($error) ?></div><?php } ?>
          <form method="post">
            <div class="form-group">
              <label>Username</label>
              <input type="text" name="username" class="form-control" value="<?= h($_POST['username'] ?? '') ?>" autofocus>
            </div>
            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
