<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $data = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
    $user = mysqli_fetch_assoc($data);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['level'] = $user['level'];

        header("Location: index.php");
        exit;
    } else {
        $pesan = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem Penjualan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff5f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #444;
        }

        .container {
            width: 350px;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(214, 51, 132, 0.15);
        }

        h2 {
            text-align: center;
            color: #d63384;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 11px;
            margin-bottom: 18px;
            border: 1px solid #edb5cd;
            border-radius: 6px;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #d63384;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #e879a9;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #d63384;
        }

        .pesan {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="card">
        <h2>Login Sistem Penjualan</h2>

        <?php if (isset($pesan)) { ?>
            <p class="pesan"><?= htmlspecialchars($pesan) ?></p>
        <?php } ?>

        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="login">Login</button>
        </form>
    </div>
</div>

</body>
</html>