
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

if ($_SESSION['role'] !== 'owner') {
    header("Location: ../home/index.php");
    exit;
}

require_once "../../config/koneksi.php";

$error = "";

if (isset($_POST['simpan'])) {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($nama == "" || $username == "" || $password == "" || $role == "") {
        $error = "Semua kolom wajib diisi.";
    } elseif (!in_array($role, ['owner', 'kasir'])) {
        $error = "Role tidak valid.";
    } else {
        $stmt = mysqli_prepare(
            $koneksi,
            "SELECT id_user FROM user WHERE username = ?"
        );

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($hasil) > 0) {
            $error = "Username sudah digunakan.";
        } else {
            $password_hash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = mysqli_prepare(
                $koneksi,
                "INSERT INTO user (nama, username, role, password)
                 VALUES (?, ?, ?, ?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "ssss",
                $nama,
                $username,
                $role,
                $password_hash
            );

            if (mysqli_stmt_execute($stmt)) {
                header("Location: user.php?pesan=tambah");
                exit;
            } else {
                $error = "User gagal ditambahkan: " . mysqli_stmt_error($stmt);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<nav>
    <a href="../home/index.php">Home</a>

    <div>
        <span>Data Master</span>
        <div>
            <a href="../barang/barang.php">Data Barang</a>
            <a href="../supplier/suplier.php">Data Supplier</a>
            <a href="../pelanggan/pelanggan.php">Data Pelanggan</a>
            <a href="user.php">Data User</a>
        </div>
    </div>

    <a href="../transaksi/transaksi.php">Transaksi</a>
    <a href="../laporan/laporan.php">Laporan</a>

    <div class="user-dropdown">
        <button class="user-button" type="button">
            <?= htmlspecialchars($_SESSION['nama']); ?>
            <span>▼</span>
        </button>

        <div class="user-dropdown-content">
            <a href="../../auth/logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container">

    <h2>Tambah User</h2>

    <?php if ($error != "") { ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php } ?>

    <form method="POST">

        <label>Nama</label>
        <input type="text" name="nama"
               value="<?= htmlspecialchars($_POST['nama'] ?? ''); ?>"
               required>

        <label>Username</label>
        <input type="text" name="username"
               value="<?= htmlspecialchars($_POST['username'] ?? ''); ?>"
               required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Role</label>
        <select name="role" required>
            <option value="">-- Pilih Role --</option>
            <option value="owner">Owner</option>
            <option value="kasir">Kasir</option>
        </select>

        <br><br>

        <button type="submit" name="simpan">Simpan</button>
        <a href="user.php" class="btn-kembali">Kembali</a>

    </form>

</div>

</body>
</html>
