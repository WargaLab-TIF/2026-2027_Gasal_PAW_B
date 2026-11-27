<?php
include "validasi.php";
include "koneksi.php";

wajib_owner();

// Mengambil daftar supplier
$supplier = mysqli_query($koneksi, "
    SELECT * FROM supplier
    ORDER BY nama_supplier ASC
");

if (!$supplier) {
    die("Gagal mengambil data supplier: " . mysqli_error($koneksi));
}

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string(
        $koneksi,
        $_POST['nama_barang']
    );

    $harga = (int) $_POST['harga'];
    $stok = (int) $_POST['stok'];

    $supplier_id = $_POST['supplier_id'] === ''
        ? null
        : (int) $_POST['supplier_id'];

    // Menambahkan barang
    $stmt = mysqli_prepare($koneksi, "
        INSERT INTO barang
        (nama_barang, harga, stok, id_supplier)
        VALUES (?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param(
        $stmt,
        "siii",
        $nama,
        $harga,
        $stok,
        $supplier_id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: data_barang.php");
        exit;
    } else {
        $pesan = "Gagal menambahkan barang: " .
            mysqli_stmt_error($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Tambah Barang</h2>

<?php
if (isset($pesan)) {
    echo "<p style='color:red;'>" .
        htmlspecialchars($pesan) .
        "</p>";
}
?>

<form method="POST">

    <label>Nama Barang</label><br>
    <input type="text" name="nama_barang" required>
    <br><br>

    <label>Harga</label><br>
    <input type="number" name="harga" min="0" required>
    <br><br>

    <label>Stok</label><br>
    <input type="number" name="stok" min="0" required>
    <br><br>

    <label>Supplier</label><br>

    <select name="supplier_id">
        <option value="">-- Pilih Supplier --</option>

        <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
            <option value="<?= $s['id_supplier']; ?>">
                <?= htmlspecialchars($s['nama_supplier']); ?>
            </option>
        <?php } ?>

    </select>

    <br><br>

    <button type="submit" name="simpan">Simpan</button>

    <a href="data_barang.php">Batal</a>

</form>

</body>
</html>
