<?php
session_start();
require_once 'koneksi.php';

if (isset($_SESSION['id_user'])) {
    header("Location: index.php");
    exit;
}

$gagal = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = mysqli_prepare($conn, "SELECT id_user, username, password, nama, level FROM `user` WHERE username = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && in_array((int)$user['level'], [1, 2], true)) {
        $valid = password_verify($password, $user['password']);

        // Untuk password lama yang masih berupa teks biasa
        if (!$valid && hash_equals((string)$user['password'], $password)) {
            $valid = true;
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $up = mysqli_prepare($conn, "UPDATE `user` SET password = ? WHERE id_user = ?");
            mysqli_stmt_bind_param($up, "si", $hash, $user['id_user']);
            mysqli_stmt_execute($up);
        }

        if ($valid) {
            session_regenerate_id(true);

            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['level'] = (int)$user['level'];

            header("Location: index.php");
            exit;
        }
    }

    $gagal = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Penjualan</title>
</head>
<body>

<h2>Login Aplikasi Penjualan</h2>

<?php if ($gagal) { ?>
    <p style="color:red;">Username atau password salah!</p>
<?php } ?>

<form method="POST">
    <label>Username</label><br>
    <input type="text" name="username" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Login</button>
</form>

</body>
</html>
