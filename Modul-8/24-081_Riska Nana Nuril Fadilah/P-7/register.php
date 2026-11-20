<?php 
require "koneksi.php";

if (isset($_POST['tombol_daftar'])) {
    global $connect;

    $username = $_POST['username'];
    $nama = $_POST['name'];
    $password = md5($_POST['password']);

    $level = 2;

    $query = "INSERT INTO user (nama, username, password, level) 
    VALUES ('$nama', '$username', '$password', '$level')";

    if (mysqli_query($connect, $query)) {
        echo "<script>alert('daftar berhasil'); window.location='login.php' </script>";
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
        <input type="submit" name="tombol_daftar" value="Daftar">
    </form>
    <a href="login.php">Batal / Login</a>
</body>
</html>