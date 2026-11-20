<?php
session_start();
include 'koneksi.php';

// Jika sudah login, langsung ke halaman utama
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST['tombol_login'])) {

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = md5($_POST['password']);

    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        if ($password == $row['password']) {

            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['level'] = $row['level'];

            header("Location: index.php");
            exit;

        } else {
            $error = "Password salah!";
        }

    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem Penjualan</title>
</head>
<body>

<h2>Login Sistem Penjualan</h2>

<?php if ($error != "") { ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php } ?>

<form method="POST">
    <label>Username</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit" name="tombol_login">Login</button>
</form>

</body>
</html>