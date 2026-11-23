<?php
require "koneksi.php";

if (isset($_POST["tombol_daftar"])) {
    global $connect;

    $username = mysqli_real_escape_string($connect, $_POST["username"]);
    $nama = mysqli_real_escape_string($connect, $_POST["name"]);
    $password = md5($_POST["password"]);
    $alamat = mysqli_real_escape_string($connect, $_POST["alamat"]);
    $hp = mysqli_real_escape_string($connect, $_POST["hp"]);
    $level = 2;

    $cek = mysqli_query($connect, "SELECT * FROM users WHERE username = '$username'");

    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('username sudah dipakai') </script>";
    } else {
        $query = "INSERT INTO users (nama, username, password, alamat, hp, level)
        VALUES ('$nama', '$username', '$password', '$alamat', '$hp', '$level')";

        if (mysqli_query($connect, $query)) {
            echo "<script>alert('daftar berhasil'); window.location='login.php' </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html>
<head><title>Daftar Akun</title></head>
<body>
    <h3>Registrasi</h3>
    <form action="" method="post">
        <input type="text" name="name" placeholder="name" required><br><br>
        <input type="text" name="username" placeholder="Username" required><br><br>
        <input type="password" name="password" placeholder="Password" required><br><br>
        <input type="text" name="alamat" placeholder="Alamat" required><br><br>
        <input type="text" name="hp" placeholder="HP" required><br><br>
        <input type="submit" name="tombol_daftar" value="Daftar">
    </form>
    <a href="login.php">Batal / Login</a>
</body>
</html>