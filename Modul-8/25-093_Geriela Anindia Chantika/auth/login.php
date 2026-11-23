
<?php
session_start();

if (isset($_SESSION['id_user'])) {
    header("Location: ../pages/home/index.php");
    exit;
}

include '../config/koneksi.php';

$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username == "" || $password == "") {
        $error = "Username dan password harus diisi.";
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "SELECT * FROM user WHERE username = ?"
        );

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);

        $hasil = mysqli_stmt_get_result($stmt);
        $data = mysqli_fetch_assoc($hasil);

        if ($data && password_verify($password, $data['password'])) {
            session_regenerate_id(true);

            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role'];

            header("Location: ../pages/home/index.php");
            exit;
        } else {
            $error = "Username atau password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Penjualan</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="login-container">
    <h2>Login Sistem Penjualan</h2>

    <?php if ($error != "") { ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php } ?>

    <form method="POST" action="">
        <label>Username</label>
        <input type="text" name="username"
               placeholder="Masukkan username"
               value="<?= htmlspecialchars($_POST['username'] ?? ''); ?>"
               required>

        <label>Password</label>
        <input type="password" name="password"
               placeholder="Masukkan password"
               required>

        <button type="submit" name="login" style="width: 100%;">
            Login
        </button>
    </form>
</div>

</body>
</html>
