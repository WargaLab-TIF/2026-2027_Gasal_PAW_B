<?php
include "koneksi.php";

$query = mysqli_query($koneksi, "
    SELECT barang.*, supplier.nama AS nama_supplier
    FROM barang
    LEFT JOIN supplier ON barang.supplier_id = supplier.id
    ORDER BY barang.id ASC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Data Master Barang</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Supplier</th>
        <th>Aksi</th>
    </tr>

    <?php while ($b = mysqli_fetch_assoc($query)) { ?>
    <tr>
        <td><?= $b['id']; ?></td>
        <td><?= htmlspecialchars($b['kode_barang']); ?></td>
        <td><?= htmlspecialchars($b['nama_barang']); ?></td>
        <td>Rp <?= number_format($b['harga'], 0, ',', '.'); ?></td>
        <td><?= $b['stok']; ?></td>
        <td><?= htmlspecialchars($b['nama_supplier'] ?? '-'); ?></td>
        <td>
            <a href="hapus_barang.php?id=<?= $b['id']; ?>"
               onclick="return confirm('Yakin ingin menghapus barang ini?')">
               Hapus
            </a>
        </td>
    </tr>
    <?php } ?>
</table>

<br>
<a href="master-detail.php">Kembali ke Transaksi</a>

</body>
</html>
