<?php
require_once "../midlewire.php";
cek_owner("../");
require_once "../koneksi.php";

$id = (int)($_GET['id'] ?? 0);
$stmt_get = mysqli_prepare($koneksi, "SELECT * FROM user WHERE id_user = ?");
mysqli_stmt_bind_param($stmt_get, "i", $id);
mysqli_stmt_execute($stmt_get);
$res_get = mysqli_stmt_get_result($stmt_get);
$data = mysqli_fetch_assoc($res_get);
mysqli_stmt_close($stmt_get);

if (!$data) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST["username"] ?? "");
    $nama     = trim($_POST["nama"] ?? "");
    $alamat   = trim($_POST["alamat"] ?? "");
    $hp       = trim($_POST["hp"] ?? "");
    $level    = (int)($_POST["level"] ?? 2);
    $new_pass = $_POST["password"] ?? "";

    if ($new_pass !== "") {
        $hashed = md5($new_pass);
        $stmt = mysqli_prepare($koneksi, "UPDATE user SET username=?, password=?, nama=?, alamat=?, hp=?, level=? WHERE id_user=?");
        mysqli_stmt_bind_param($stmt, "sssssii", $username, $hashed, $nama, $alamat, $hp, $level, $id);
    } else {
        $stmt = mysqli_prepare($koneksi, "UPDATE user SET username=?, nama=?, alamat=?, hp=?, level=? WHERE id_user=?");
        mysqli_stmt_bind_param($stmt, "ssssii", $username, $nama, $alamat, $hp, $level, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    }

    $error = mysqli_stmt_error($stmt);
}

$judul = "Edit User";
include "../header.php";
?>

<h2>Edit User</h2>

<?php if (isset($error)) { ?>
    <div class="msg"><?= htmlspecialchars($error) ?></div>
<?php } ?>

<form method="post">
    <label>ID User</label>
    <input type="number" value="<?= (int)$data['id_user'] ?>" readonly>

    <label>Username</label>
    <input name="username" type="text" value="<?= htmlspecialchars($data['username'] ?? '') ?>" required>

    <label>Password (kosongkan jika tidak ingin mengubah)</label>
    <input name="password" type="password" placeholder="Isi password baru jika ingin mengganti">

    <label>Nama</label>
    <input name="nama" type="text" value="<?= htmlspecialchars($data['nama'] ?? '') ?>" required>

    <label>Alamat</label>
    <input name="alamat" type="text" value="<?= htmlspecialchars($data['alamat'] ?? '') ?>" required>

    <label>HP</label>
    <input name="hp" type="text" value="<?= htmlspecialchars($data['hp'] ?? '') ?>" required>

    <label>Level</label>
    <select name="level" required>
        <option value="1" <?= ((int)$data['level'] === 1) ? 'selected' : '' ?>>1 - Owner</option>
        <option value="2" <?= ((int)$data['level'] === 2) ? 'selected' : '' ?>>2 - Kasir</option>
    </select>

    <button class="btn">Simpan Perubahan</button>
    <a class="btn danger" href="index.php">Kembali</a>
</form>

<?php include "../footer.php"; ?>
