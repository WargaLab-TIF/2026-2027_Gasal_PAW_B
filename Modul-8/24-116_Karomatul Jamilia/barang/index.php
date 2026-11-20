<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

$data = getBarang();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Barang</title>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <h2>Data Barang</h2>
    <a href="tambah.php">+ Tambah barang</a>
    <br><br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Supplier</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; foreach ($data as $row) : ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row["kode_barang"]) ?></td>
            <td><?= htmlspecialchars($row["nama_barang"]) ?></td>
            <td>Rp <?= number_format($row["harga"], 0, ',', '.') ?></td>
            <td><?= (int)$row["stok"] ?></td>
            <td><?= htmlspecialchars($row["nama_supplier"] ?? "-") ?></td>
            <td>
                <a href="edit.php?id=<?= $row["id_barang"] ?>">Edit</a> |
                <a href="hapus.php?id=<?= $row["id_barang"] ?>" onclick="return confirm('Anda yakin ingin menghapus barang ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
