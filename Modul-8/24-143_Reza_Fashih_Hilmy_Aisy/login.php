<?php
session_start();
include "koneksi.php";

if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['tombol_login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($password == $row['password'] || $_POST['password'] == $row['password']) {
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['level'] = $row['level'];

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
<head>
    <title>Halaman Login</title>
    <style>
        body { font-family: Arial; background-color: whitesmoke; margin: 30px; }
        .login { background-color: white; width: 300px; padding: 20px; }
        input { padding: 8px; margin-bottom: 10px; width: 95%; }
        input[type=submit] { width: auto; cursor: pointer; }
        .pesan { color: red; }
    </style>
</head>
<body>
    <div class="login">
        <h3>Silakan Login</h3>
        <?php if (isset($pesan)) { echo '<p class="pesan">' . $pesan . '</p>'; } ?>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" name="tombol_login" value="Login Masuk">
        </form>
    </div>
</body>
</html>
