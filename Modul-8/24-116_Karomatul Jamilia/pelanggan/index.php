<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

$data = getPelanggan();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Pelanggan</title>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <h2>Data Pelanggan</h2>
    <a href="tambah.php">+ Tambah pelanggan</a>
    <br><br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>Nama</th>
            <th>JK</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; foreach ($data as $row) : ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row["id_pelanggan"]) ?></td>
            <td><?= htmlspecialchars($row["nama"]) ?></td>
            <td><?= htmlspecialchars($row["jenis_kelamin"]) ?></td>
            <td><?= htmlspecialchars($row["telp"]) ?></td>
            <td><?= htmlspecialchars($row["alamat"]) ?></td>
            <td>
                <a href="edit.php?id=<?= urlencode($row["id_pelanggan"]) ?>">Edit</a> |
                <a href="hapus.php?id=<?= urlencode($row["id_pelanggan"]) ?>" onclick="return confirm('Anda yakin ingin menghapus pelanggan ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
