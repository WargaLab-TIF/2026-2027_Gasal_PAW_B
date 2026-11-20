<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

$data = getAllBarang();
$status = $_GET['status'] ?? "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Data Master Barang</h2>
    <?php if ($status == "gagal_hapus"): ?>
        <p style="color: red;"><b>Gagal dihapus! Barang tersebut masih digunakan pada data transaksi.</b></p>
    <?php elseif ($status == "sukses_hapus"): ?>
        <p style="color: green;"><b>Data barang berhasil dihapus.</b></p>
    <?php endif; ?>

    <a href="tambah_barang.php">+ Tambah Barang</a><br><br>

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
        <?php $no = 1; foreach ($data as $row): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row["kode_barang"]) ?></td>
            <td><?= htmlspecialchars($row["nama_barang"]) ?></td>
            <td>Rp. <?= number_format($row["harga"], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($row["stok"]) ?></td>
            <td><?= htmlspecialchars($row["nama_supplier"] ?? "-") ?></td>
            <td>
                <a href="edit_barang.php?id=<?= $row["id"] ?>">Edit</a> |
                <a href="hapus_barang.php?id=<?= $row["id"] ?>" onclick="return confirm('Yakin hapus barang ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
