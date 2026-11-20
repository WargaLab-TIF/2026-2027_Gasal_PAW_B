<?php
include 'koneksi.php';

if (isset($_SESSION['id_user'], $_SESSION['nama'], $_SESSION['level'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if (isset($_POST['login'])) {
    $username = esc($_POST['username']);
    $password = esc($_POST['password']);

    if ($username == '' || $password == '') {
        $error = 'Username dan password wajib diisi.';
    } else {
        $q = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password'");
        $user = mysqli_fetch_assoc($q);

        if ($user && ($user['level'] == 1 || $user['level'] == 2)) {
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['level']   = $user['level'];
            header('Location: index.php');
            exit;
        } else {
            $error = 'Username atau password salah.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container" style="max-width:380px; margin-top:12vh">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h4 class="text-center mb-3">Login</h4>
            <?php if (isset($_GET['logout'])) { ?>
                <div class="alert alert-success">Anda sudah logout.</div>
            <?php } ?>
            <?php if ($error != '') { ?>
                <div class="alert alert-danger"><?= h($error) ?></div>
            <?php } ?>
            <form method="post">
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button name="login" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
