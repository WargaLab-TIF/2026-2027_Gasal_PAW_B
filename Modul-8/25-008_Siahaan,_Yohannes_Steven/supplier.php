<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

$data = getAllSupplier();
$status = $_GET['status'] ?? "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Data Master Supplier</h2>
    <?php if ($status == "gagal_hapus"): ?>
        <p style="color: red;"><b>Gagal dihapus! Supplier masih digunakan pada data barang.</b></p>
    <?php elseif ($status == "sukses_hapus"): ?>
        <p style="color: green;"><b>Data supplier berhasil dihapus.</b></p>
    <?php endif; ?>

    <a href="tambah_supplier.php">+ Tambah Supplier</a><br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; foreach ($data as $row): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row["nama"]) ?></td>
            <td><?= htmlspecialchars($row["telp"]) ?></td>
            <td><?= htmlspecialchars($row["alamat"]) ?></td>
            <td>
                <a href="edit_supplier.php?id=<?= $row["id"] ?>">Edit</a> |
                <a href="hapus_supplier.php?id=<?= $row["id"] ?>" onclick="return confirm('Anda yakin akan menghapus supplier ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
