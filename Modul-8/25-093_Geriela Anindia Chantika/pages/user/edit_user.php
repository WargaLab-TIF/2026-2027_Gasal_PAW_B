
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

include '../../config/koneksi.php';

$error = "";

// Mengambil ID user dari URL
if (!isset($_GET['id'])) {
    header("Location: user.php");
    exit;
}

$id_user = (int) $_GET['id'];

// Mengambil data user berdasarkan ID
$stmt = mysqli_prepare(
    $koneksi,
    "SELECT * FROM user WHERE id_user = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    header("Location: user.php");
    exit;
}

// Proses update user
if (isset($_POST['update'])) {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if ($nama == "" || $username == "") {
        $error = "Nama dan username wajib diisi.";
    } elseif (!in_array($role, ['owner', 'kasir'])) {
        $error = "Role tidak valid.";
    } else {
        // Cek username milik user lain
        $stmt = mysqli_prepare(
            $koneksi,
            "SELECT id_user FROM user
             WHERE username = ? AND id_user != ?"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "si",
            $username,
            $id_user
        );

        mysqli_stmt_execute($stmt);
        $cek = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($cek) > 0) {
            $error = "Username sudah digunakan.";
        } else {
            if ($password != "") {
                // Update termasuk password
                $password_hash = password_hash(
                    $password,
                    PASSWORD_DEFAULT
                );

                $stmt = mysqli_prepare(
                    $koneksi,
                    "UPDATE user
                     SET nama = ?, username = ?, role = ?, password = ?
                     WHERE id_user = ?"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "ssssi",
                    $nama,
                    $username,
                    $role,
                    $password_hash,
                    $id_user
                );
            } else {
                // Update tanpa mengubah password
                $stmt = mysqli_prepare(
                    $koneksi,
                    "UPDATE user
                     SET nama = ?, username = ?, role = ?
                     WHERE id_user = ?"
                );

                mysqli_stmt_bind_param(
                    $stmt,
                    "sssi",
                    $nama,
                    $username,
                    $role,
                    $id_user
                );
            }

            if (mysqli_stmt_execute($stmt)) {
                // Perbarui session jika mengedit akun sendiri
                if ($id_user == $_SESSION['id_user']) {
                    $_SESSION['nama'] = $nama;
                    $_SESSION['role'] = $role;
                }

                // Jika akun sendiri berubah menjadi kasir,
                // arahkan ke halaman Home
                if ($id_user == $_SESSION['id_user']
                    && $role == 'kasir') {
                    header("Location: ../home/index.php");
                    exit;
                }

                header("Location: user.php?pesan=edit");
                exit;
            } else {
                $error = "Data user gagal diperbarui.";
            }
        }
    }

    // Menjaga nilai form setelah validasi gagal
    $data['nama'] = $nama;
    $data['username'] = $username;
    $data['role'] = $role;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<!-- Navbar -->
<nav>
    <a href="../home/index.php">Home</a>

    <div>
        <span>Data Master</span>
        <div>
            <a href="../barang/barang.php">Data Barang</a>
            <a href="../pelanggan/pelanggan.php">Data Pelanggan</a>
            <a href="../supplier/supplier.php">Data Supplier</a>
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

<h2>Edit User</h2>

<?php if ($error != "") { ?>
    <p><?= htmlspecialchars($error); ?></p>
<?php } ?>

<form method="POST">

    <label>Nama</label><br>
    <input type="text" name="nama"
           value="<?= htmlspecialchars($data['nama']); ?>"
           required>
    <br><br>

    <label>Username</label><br>
    <input type="text" name="username"
           value="<?= htmlspecialchars($data['username']); ?>"
           required>
    <br><br>

    <label>Password</label><br>
    <input type="password" name="password"
           placeholder="Kosongkan jika tidak diubah">
    <br><br>

    <label>Role</label><br>
    <select name="role" required>
        <option value="owner"
            <?= $data['role'] == 'owner' ? 'selected' : ''; ?>>
            Owner
        </option>

        <option value="kasir"
            <?= $data['role'] == 'kasir' ? 'selected' : ''; ?>>
            Kasir
        </option>
    </select>
    <br><br>

    <button type="submit" name="update">Update</button>
    <a href="user.php" class="btn-kembali">Kembali</a>

</form>

</body>
</html>
