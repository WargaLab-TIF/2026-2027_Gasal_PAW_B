<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

$data = getSupplier();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Supplier</title>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <h2>Data Supplier</h2>
    <a href="tambah.php">+ Tambah supplier</a>
    <br><br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; foreach ($data as $row) : ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row["nama"]) ?></td>
            <td><?= htmlspecialchars($row["telp"]) ?></td>
            <td><?= htmlspecialchars($row["alamat"]) ?></td>
            <td>
                <a href="edit.php?id=<?= $row["id_supplier"] ?>">Edit</a> |
                <a href="hapus.php?id=<?= $row["id_supplier"] ?>" onclick="return confirm('Anda yakin ingin menghapus supplier ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
