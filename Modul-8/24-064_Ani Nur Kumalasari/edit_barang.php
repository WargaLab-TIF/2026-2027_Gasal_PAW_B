<?php
include "validasi.php";
include "koneksi.php";
wajib_owner();

$id = (int) ($_GET['id'] ?? 0);

$stmt = mysqli_prepare($koneksi, "SELECT * FROM barang WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$barang = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$barang) {
    die("Barang tidak ditemukan.");
}

$supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama ASC");

if (isset($_POST['simpan'])) {
    $kode = mysqli_real_escape_string($koneksi, $_POST['kode_barang']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $harga = (int) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $supplier_id = $_POST['supplier_id'] === '' ? null : (int) $_POST['supplier_id'];

    $stmt = mysqli_prepare($koneksi, "
        UPDATE barang
        SET kode_barang=?, nama_barang=?, harga=?, stok=?, supplier_id=?
        WHERE id=?
    ");

    mysqli_stmt_bind_param($stmt, "ssiiii", $kode, $nama, $harga, $stok, $supplier_id, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: data_barang.php");
        exit;
    } else {
        $pesan = "Gagal mengubah barang.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Edit Barang</h2>

<?php if (isset($pesan)) echo htmlspecialchars($pesan); ?>

<form method="POST">
    <label>Kode Barang</label><br>
    <input type="text" name="kode_barang"
           value="<?= htmlspecialchars($barang['kode_barang']); ?>" required><br><br>

    <label>Nama Barang</label><br>
    <input type="text" name="nama_barang"
           value="<?= htmlspecialchars($barang['nama_barang']); ?>" required><br><br>

    <label>Harga</label><br>
    <input type="number" name="harga" min="0"
           value="<?= $barang['harga']; ?>" required><br><br>

    <label>Stok</label><br>
    <input type="number" name="stok" min="0"
           value="<?= $barang['stok']; ?>" required><br><br>

    <label>Supplier</label><br>
    <select name="supplier_id">
        <option value="">-- Pilih Supplier --</option>
        <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
            <option value="<?= $s['id']; ?>"
                <?= $barang['supplier_id'] == $s['id'] ? 'selected' : ''; ?>>
                <?= htmlspecialchars($s['nama']); ?>
            </option>
        <?php } ?>
    </select><br><br>

    <button type="submit" name="simpan">Simpan Perubahan</button>
    <a href="data_barang.php">Batal</a>
</form>

</body>
</html>
