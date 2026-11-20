<?php
require_once "../midlewire.php";
cek_owner("../");
require_once "../koneksi.php";

$id = (int)($_GET['id'] ?? 0);
$stmt_get = mysqli_prepare($koneksi, "SELECT * FROM barang WHERE id = ?");
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
    $kode  = $_POST['kode_barang'];
    $nama  = $_POST['nama_barang'];
    $harga = (int)$_POST['harga'];
    $stok  = (int)$_POST['stok'];
    $sid   = $_POST['supplier_id'] !== '' ? (int)$_POST['supplier_id'] : null;

    $st = mysqli_prepare(
        $koneksi,
        "UPDATE barang SET kode_barang=?, nama_barang=?, harga=?, stok=?, supplier_id=? WHERE id=?"
    );
    mysqli_stmt_bind_param($st, "ssiiii", $kode, $nama, $harga, $stok, $sid, $id);

    if (mysqli_stmt_execute($st)) {
        header("Location: index.php");
        exit;
    }

    $error = mysqli_error($koneksi);
}

$judul = "Edit Barang";
include "../header.php";

$s = mysqli_query($koneksi, "SELECT id, nama FROM supplier ORDER BY nama");
?>

<h2>Edit Barang</h2>

<?php if (isset($error)) { ?>
    <div class="msg"><?= htmlspecialchars($error) ?></div>
<?php } ?>

<form method="post">
    <label>Kode Barang</label>
    <input name="kode_barang" value="<?= htmlspecialchars($data['kode_barang']) ?>" required>

    <label>Nama Barang</label>
    <input name="nama_barang" value="<?= htmlspecialchars($data['nama_barang']) ?>" required>

    <label>Harga</label>
    <input name="harga" type="number" min="0" value="<?= (int)$data['harga'] ?>" required>

    <label>Stok</label>
    <input name="stok" type="number" min="0" value="<?= (int)$data['stok'] ?>" required>

    <label>Supplier</label>
    <select name="supplier_id">
        <option value="">-- Pilih supplier --</option>
        <?php while ($x = mysqli_fetch_assoc($s)) { ?>
            <option value="<?= $x['id'] ?>" <?= ($x['id'] == $data['supplier_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($x['nama']) ?>
            </option>
        <?php } ?>
    </select>

    <button class="btn">Simpan Perubahan</button>
    <a class="btn danger" href="index.php">Kembali</a>
</form>

<?php include "../footer.php"; ?>
