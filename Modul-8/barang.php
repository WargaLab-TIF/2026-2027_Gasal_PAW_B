<?php
include 'auth.php';
khususOwner();
include 'koneksi.php';

$pesan = "";

if (isset($_POST['tambah'])) {
    $kode = $_POST['kode_barang'];
    $nama = $_POST['nama_barang'];
    $harga = (int) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $supplier = (int) $_POST['supplier_id'];

    $stmt = mysqli_prepare($conn,
        "INSERT INTO barang
        (kode_barang, nama_barang, harga, stok, supplier_id)
        VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt, "ssiii",
        $kode, $nama, $harga, $stok, $supplier
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: barang.php");
        exit;
    } else {
        $pesan = "Gagal menambahkan barang! Pastikan kode barang tidak sama.";
    }
}

if (isset($_POST['edit'])) {
    $id = (int) $_POST['id'];
    $kode = $_POST['kode_barang'];
    $nama = $_POST['nama_barang'];
    $harga = (int) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $supplier = (int) $_POST['supplier_id'];

    $stmt = mysqli_prepare($conn,
        "UPDATE barang SET
        kode_barang=?, nama_barang=?, harga=?, stok=?, supplier_id=?
        WHERE id=?"
    );

    mysqli_stmt_bind_param(
        $stmt, "ssiiii",
        $kode, $nama, $harga, $stok, $supplier, $id
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: barang.php");
        exit;
    } else {
        $pesan = "Gagal mengedit barang! Periksa kembali kode barang.";
    }
}

if (isset($_POST['hapus'])) {
    $id = (int) $_POST['id'];

    $stmt = mysqli_prepare($conn,
        "DELETE FROM barang WHERE id=?"
    );
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: barang.php");
        exit;
    } else {
        $pesan = "Barang tidak bisa dihapus karena sudah digunakan dalam transaksi!";
    }
}

$dataEdit = null;

if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];

    $stmt = mysqli_prepare($conn,
        "SELECT * FROM barang WHERE id=?"
    );
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $dataEdit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$dataSupplier = mysqli_query($conn,
    "SELECT * FROM supplier ORDER BY nama ASC"
);

$dataBarang = mysqli_query($conn,
    "SELECT barang.*, supplier.nama AS nama_supplier
    FROM barang
    JOIN supplier ON barang.supplier_id = supplier.id
    ORDER BY barang.id DESC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
</head>
<body>

<?php include 'navbar.php'; ?>

<h2>Data Barang</h2>

<p style="color:red;">
    <?= htmlspecialchars($pesan) ?>
</p>

<h3><?= $dataEdit ? "Edit Barang" : "Tambah Barang" ?></h3>

<form method="POST">

    <?php if ($dataEdit) { ?>
        <input type="hidden" name="id"
            value="<?= $dataEdit['id'] ?>">
    <?php } ?>

    <label>Kode Barang</label><br>
    <input type="text" name="kode_barang" required
        value="<?= htmlspecialchars($dataEdit['kode_barang'] ?? '') ?>">
    <br><br>

    <label>Nama Barang</label><br>
    <input type="text" name="nama_barang" required
        value="<?= htmlspecialchars($dataEdit['nama_barang'] ?? '') ?>">
    <br><br>

    <label>Harga</label><br>
    <input type="number" name="harga" min="0" required
        value="<?= htmlspecialchars($dataEdit['harga'] ?? '') ?>">
    <br><br>

    <label>Stok</label><br>
    <input type="number" name="stok" min="0" required
        value="<?= htmlspecialchars($dataEdit['stok'] ?? '') ?>">
    <br><br>

    <label>Supplier</label><br>
    <select name="supplier_id" required>
        <option value="">-- Pilih Supplier --</option>

        <?php while ($s = mysqli_fetch_assoc($dataSupplier)) { ?>
            <option value="<?= $s['id'] ?>"
                <?= isset($dataEdit['supplier_id']) &&
                    $dataEdit['supplier_id'] == $s['id']
                    ? 'selected' : '' ?>>
                <?= htmlspecialchars($s['nama']) ?>
            </option>
        <?php } ?>

    </select>
    <br><br>

    <?php if ($dataEdit) { ?>
        <button type="submit" name="edit">Simpan Perubahan</button>
        <a href="barang.php">Batal</a>
    <?php } else { ?>
        <button type="submit" name="tambah">Tambah Barang</button>
    <?php } ?>

</form>

<hr>

<h3>Daftar Barang</h3>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Supplier</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; ?>
    <?php while ($row = mysqli_fetch_assoc($dataBarang)) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['kode_barang']) ?></td>
        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
        <td><?= $row['stok'] ?></td>
        <td><?= htmlspecialchars($row['nama_supplier']) ?></td>
        <td>
            <a href="barang.php?edit=<?= $row['id'] ?>">Edit</a>

            <form method="POST" style="display:inline;"
                onsubmit="return confirm('Yakin ingin menghapus barang?')">
                <input type="hidden" name="id"
                    value="<?= $row['id'] ?>">
                <button type="submit" name="hapus">Hapus</button>
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>