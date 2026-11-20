<?php
require_once "../midlewire.php";
cek_owner("../");
require_once "../koneksi.php";

$id = (int)($_GET['id'] ?? 0);
$stmt_get = mysqli_prepare($koneksi, "SELECT * FROM supplier WHERE id = ?");
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
    $nama   = $_POST["nama"] ?? "";
    $telp   = $_POST["telp"] ?? "";
    $alamat = $_POST["alamat"] ?? "";

    $stmt = mysqli_prepare($koneksi, "UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssi", $nama, $telp, $alamat, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: index.php");
        exit;
    }

    $error = mysqli_stmt_error($stmt);
}

$judul = "Edit Supplier";
include "../header.php";
?>

<h2>Edit Supplier</h2>

<?php if (isset($error)) { ?>
    <div class="msg"><?= htmlspecialchars($error) ?></div>
<?php } ?>

<form method="post">
    <label>Nama</label>
    <input name="nama" type="text" value="<?= htmlspecialchars($data['nama'] ?? '') ?>" required>

    <label>Telepon</label>
    <input name="telp" type="text" value="<?= htmlspecialchars($data['telp'] ?? '') ?>" required>

    <label>Alamat</label>
    <textarea name="alamat" required><?= htmlspecialchars($data['alamat'] ?? '') ?></textarea>

    <button class="btn">Simpan Perubahan</button>
    <a class="btn danger" href="index.php">Kembali</a>
</form>

<?php include "../footer.php"; ?>
