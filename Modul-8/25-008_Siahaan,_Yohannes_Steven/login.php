<?php
session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
    header("Location: index.php");
    exit();
}

require "koneksi.php";

$pesan_error = "";

if (isset($_POST['tombol_login'])) {
    $username = trim($_POST['username'] ?? "");
    $password_input = trim($_POST['password'] ?? "");

    if ($username === "" || $password_input === "") {
        $pesan_error = "Username dan password wajib diisi.";
    } else {
        $password = md5($password_input);
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($password == $row['password']) {
                $_SESSION['login'] = true;
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['nama'] = $row['nama'];
                $_SESSION['level'] = $row['level'];
                header("Location: index.php");
                exit();
            } else {
                $pesan_error = "Password salah.";
            }
        } else {
            $pesan_error = "Username tidak ditemukan.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <h2>Login</h2>
    <?php if ($pesan_error != ""): ?>
        <p style="color: red;"><?= htmlspecialchars($pesan_error) ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" name="tombol_login" value="Login">
    </form>
</body>
</html>
