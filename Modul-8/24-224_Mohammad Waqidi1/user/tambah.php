<?php
require_once "../midlewire.php";
cek_owner("../");
require_once "../koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "INSERT INTO user (id_user, username, password, nama, alamat, hp, level) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);

    $id_user  = (int)($_POST["id_user"] ?? 0);
    $username = trim($_POST["username"] ?? "");
    $password = md5($_POST["password"] ?? "");
    $nama     = trim($_POST["nama"] ?? "");
    $alamat   = trim($_POST["alamat"] ?? "");
    $hp       = trim($_POST["hp"] ?? "");
    $level    = (int)($_POST["level"] ?? 2);

    mysqli_stmt_bind_param($stmt, "isssssi", $id_user, $username, $password, $nama, $alamat, $hp, $level);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    }

    $error = mysqli_stmt_error($stmt);
}

$judul = "Tambah User";
include "../header.php";
?>

<h2>Tambah User</h2>

<?php if (isset($error)) { ?>
    <div class="msg"><?= htmlspecialchars($error) ?></div>
<?php } ?>

<form method="post">
    <label>ID User</label>
    <input name="id_user" type="number" required>

    <label>Username</label>
    <input name="username" type="text" required>

    <label>Password</label>
    <input name="password" type="password" required>

    <label>Nama</label>
    <input name="nama" type="text" required>

    <label>Alamat</label>
    <input name="alamat" type="text" required>

    <label>HP</label>
    <input name="hp" type="text" required>

    <label>Level</label>
    <select name="level" required>
        <option value="1">1 - Owner</option>
        <option value="2">2 - Kasir</option>
    </select>

    <button class="btn">Simpan</button>
    <a class="btn danger" href="index.php">Kembali</a>
</form>

<?php include "../footer.php"; ?>
