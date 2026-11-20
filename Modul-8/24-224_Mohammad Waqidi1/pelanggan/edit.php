<?php
require_once "../midlewire.php";
cek_owner("../");
require_once "../koneksi.php";

$id = $_GET['id'] ?? '';
$stmt_get = mysqli_prepare($koneksi, "SELECT * FROM pelanggan WHERE id = ?");
mysqli_stmt_bind_param($stmt_get, "s", $id);
mysqli_stmt_execute($stmt_get);
$res_get = mysqli_stmt_get_result($stmt_get);
$data = mysqli_fetch_assoc($res_get);
mysqli_stmt_close($stmt_get);

if (!$data) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = $_POST["nama"] ?? "";
    $jk     = $_POST["jenis_kelamin"] ?? "";
    $telp   = $_POST["telp"] ?? "";
    $alamat = $_POST["alamat"] ?? "";

    $stmt = mysqli_prepare($koneksi, "UPDATE pelanggan SET nama=?, jenis_kelamin=?, telp=?, alamat=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssss", $nama, $jk, $telp, $alamat, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    }

    $error = mysqli_stmt_error($stmt);
}

$judul = "Edit Pelanggan";
include "../header.php";
?>

<h2>Edit Pelanggan</h2>

<?php if (isset($error)) { ?>
    <div class="msg"><?= htmlspecialchars($error) ?></div>
<?php } ?>

<form method="post">
    <label>ID Pelanggan</label>
    <input type="text" value="<?= htmlspecialchars($data['id'] ?? '') ?>" readonly>

    <label>Nama</label>
    <input name="nama" type="text" value="<?= htmlspecialchars($data['nama'] ?? '') ?>" required>

    <label>Jenis Kelamin</label>
    <select name="jenis_kelamin">
        <option value="L" <?= (($data['jenis_kelamin'] ?? '') === 'L') ? 'selected' : '' ?>>Laki-laki</option>
        <option value="P" <?= (($data['jenis_kelamin'] ?? '') === 'P') ? 'selected' : '' ?>>Perempuan</option>
    </select>

    <label>Telepon</label>
    <input name="telp" type="text" value="<?= htmlspecialchars($data['telp'] ?? '') ?>" required>

    <label>Alamat</label>
    <textarea name="alamat" required><?= htmlspecialchars($data['alamat'] ?? '') ?></textarea>

    <button class="btn">Simpan Perubahan</button>
    <a class="btn danger" href="index.php">Kembali</a>
</form>

<?php include "../footer.php"; ?>
