<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}

$pesan = "";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");

    if (mysqli_num_rows($query) > 0) {

        $data = mysqli_fetch_assoc($query);

        $passwordBenar = password_get_info($data['password'])['algo']
            ? password_verify($password, $data['password'])
            : hash_equals((string)$data['password'], $password);

        if ($passwordBenar) {

            session_regenerate_id(true);

            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['level'] = $data['level'];

            header("Location: index.php");
            exit;

        } else {
            $pesan = "Password yang kamu masukkan salah!";
        }

    } else {
        $pesan = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Sistem Penjualan</title>
</head>
<body>

    <h2>Login Sistem Penjualan</h2>

    <form method="POST">

        <label>Username</label><br>
        <input type="text" name="username" required>
        <br><br>

        <label>Password</label><br>
        <input type="password" name="password" required>
        <br><br>

        <button type="submit" name="login">Login</button>

    </form>

    <p style="color:red;">
        <?php echo htmlspecialchars($pesan); ?>
    </p>

</body>
</html>