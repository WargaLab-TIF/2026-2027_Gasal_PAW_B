<?php
require_once "middleware.php";
require_once "koneksi.php";

cekSudahLogin();

$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Username dan password wajib diisi!";
    } else {

        $stmt = mysqli_prepare($conn, "SELECT id_user, username, password, nama, level FROM user WHERE username = ?");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {

                if ($password === $row['password']) {

                    session_regenerate_id(true);

                    $_SESSION['login']    = true;
                    $_SESSION['id_user']  = $row['id_user'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['nama']     = $row['nama'];
                    $_SESSION['level']    = (int)$row['level'];

                    header("Location: index.php");
                    exit;
                } else {
                    $error = "Password salah!";
                }
            } else {
                $error = "Username tidak ditemukan!";
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Terjadi gangguan pada query database!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login - Sistem Penjualan</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f4f6f9;
            font-family: Arial, sans-serif;
        }
        .login-box {
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 360px;
            box-sizing: border-box;
        }
        .login-box h2 {
            margin-top: 0;
            margin-bottom: 20px;
            text-align: center;
            color: #333333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #555555;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }
        .btn-login {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-login:hover {
            background-color: #0056b3;
        }
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 13px;
            border: 1px solid #f5c6cb;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="login-box">
    <h2>Login Sistem</h2>

    <?php if (!empty($error)): ?>
        <div class="alert-error"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required autocomplete="off">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        </div>

        <button type="submit" name="login" class="btn-login">Masuk</button>
    </form>
</div>

</body>
</html>

