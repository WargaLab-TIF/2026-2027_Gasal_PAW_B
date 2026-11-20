<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

$data = getAllPelanggan();
$status = $_GET['status'] ?? "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Data Master Pelanggan</h2>
    <?php if ($status == "gagal_hapus"): ?>
        <p style="color: red;"><b>Gagal dihapus! Pelanggan masih memiliki riwayat transaksi.</b></p>
    <?php elseif ($status == "sukses_hapus"): ?>
        <p style="color: green;"><b>Data pelanggan berhasil dihapus.</b></p>
    <?php endif; ?>

    <a href="tambah_pelanggan.php">+ Tambah Pelanggan</a><br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID Pelanggan</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row["id"]) ?></td>
            <td><?= htmlspecialchars($row["nama"]) ?></td>
            <td><?= htmlspecialchars($row["jenis_kelamin"]) ?></td>
            <td><?= htmlspecialchars($row["telp"]) ?></td>
            <td><?= htmlspecialchars($row["alamat"]) ?></td>
            <td>
                <a href="edit_pelanggan.php?id=<?= htmlspecialchars($row["id"]) ?>">Edit</a> |
                <a href="hapus_pelanggan.php?id=<?= htmlspecialchars($row["id"]) ?>" onclick="return confirm('Yakin hapus pelanggan ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
