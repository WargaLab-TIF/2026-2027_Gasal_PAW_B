<?php
include 'auth.php';
khususOwner();
include 'koneksi.php';

$pesan = "";

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $stmt = mysqli_prepare($conn,
        "INSERT INTO supplier (nama, telp, alamat) VALUES (?, ?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "sss", $nama, $telp, $alamat);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: supplier.php");
        exit;
    } else {
        $pesan = "Gagal menambahkan supplier!";
    }
}

if (isset($_POST['edit'])) {
    $id = (int) $_POST['id'];
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $stmt = mysqli_prepare($conn,
        "UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id=?"
    );
    mysqli_stmt_bind_param($stmt, "sssi", $nama, $telp, $alamat, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: supplier.php");
        exit;
    } else {
        $pesan = "Gagal mengedit supplier!";
    }
}

if (isset($_POST['hapus'])) {
    $id = (int) $_POST['id'];

    $stmt = mysqli_prepare($conn,
        "DELETE FROM supplier WHERE id=?"
    );
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: supplier.php");
        exit;
    } else {
        $pesan = "Supplier tidak bisa dihapus karena masih digunakan oleh data barang!";
    }
}

$dataEdit = null;

if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];

    $stmt = mysqli_prepare($conn,
        "SELECT * FROM supplier WHERE id=?"
    );
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $dataEdit = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}

$dataSupplier = mysqli_query($conn,
    "SELECT * FROM supplier ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Supplier</title>
</head>
<body>

<?php include 'navbar.php'; ?>

<h2>Data Supplier</h2>

<p style="color:red;">
    <?= htmlspecialchars($pesan) ?>
</p>

<h3><?= $dataEdit ? "Edit Supplier" : "Tambah Supplier" ?></h3>

<form method="POST">

    <?php if ($dataEdit) { ?>
        <input type="hidden" name="id"
            value="<?= $dataEdit['id'] ?>">
    <?php } ?>

    <label>Nama Supplier</label><br>
    <input type="text" name="nama" required
        value="<?= htmlspecialchars($dataEdit['nama'] ?? '') ?>">
    <br><br>

    <label>Telepon</label><br>
    <input type="text" name="telp"
        value="<?= htmlspecialchars($dataEdit['telp'] ?? '') ?>">
    <br><br>

    <label>Alamat</label><br>
    <textarea name="alamat"><?= htmlspecialchars($dataEdit['alamat'] ?? '') ?></textarea>
    <br><br>

    <?php if ($dataEdit) { ?>
        <button type="submit" name="edit">Simpan Perubahan</button>
        <a href="supplier.php">Batal</a>
    <?php } else { ?>
        <button type="submit" name="tambah">Tambah Supplier</button>
    <?php } ?>

</form>

<hr>

<h3>Daftar Supplier</h3>

<table border="1" cellpadding="8" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama Supplier</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1; ?>
    <?php while ($row = mysqli_fetch_assoc($dataSupplier)) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['nama']) ?></td>
        <td><?= htmlspecialchars($row['telp']) ?></td>
        <td><?= htmlspecialchars($row['alamat']) ?></td>
        <td>
            <a href="supplier.php?edit=<?= $row['id'] ?>">Edit</a>

            <form method="POST" style="display:inline;"
                onsubmit="return confirm('Yakin ingin menghapus supplier?')">
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