<?php
session_start();

require "koneksi.php";

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST["tombol_login"])) {
    global $connect;

    $username = mysqli_real_escape_string($connect, trim($_POST["username"]));
    $password = $_POST["password"];

    if ($username === "" || $password === "") {
        echo "<script>alert('username dan password wajib diisi') </script>";
    } else {
        $password = md5($password);

        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($password == $row["password"]) {
                $_SESSION["login"] = True;
                $_SESSION["username"] = $row["username"];
                $_SESSION["level"] = $row["level"];
                $_SESSION["id_user"] = $row["id_user"];
                header("Location: index.php");
                exit();
            } else {
                echo "<script>alert('password salah') </script>";
            }
        } else {
            echo "<script>alert('username tidak ditemukan') </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Halaman Login</title>
</head>
<body>
    <h3>Silakan Login</h3>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="submit" name="tombol_login" value="Login Masuk">
    </form>
    <br>
    <a href="register.php">Daftar Akun</a>
</body>
</html>
