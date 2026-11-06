<?php
include "koneksi.php";

$query = mysqli_query($koneksi, "
    SELECT 
        transaksi.*,
        pelanggan.nama AS nama_pelanggan
    FROM transaksi
    LEFT JOIN pelanggan
        ON transaksi.pelanggang_id = pelanggan.id
    ORDER BY transaksi.id DESC
");

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Master Detail Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Data Master Transaksi</h2>

<a href="tambah_transaksi.php" class="btn-tambah">
    + Tambah Transaksi
</a>

<table>
    <tr>
        <th>ID</th>
        <th>Nama Pelanggan</th>
        <th>Waktu Transaksi</th>
        <th>Keterangan</th>
        <th>Total</th>
        <th>Detail</th>
    </tr>

    <?php while ($data = mysqli_fetch_assoc($query)) { ?>
    <tr>
        <td><?= $data['id']; ?></td>

        <td>
            <?= htmlspecialchars($data['nama_pelanggan'] ?? '-'); ?>
        </td>

        <td><?= $data['waktu_transaksi']; ?></td>

        <td>
            <?= htmlspecialchars($data['keterangan'] ?? '-'); ?>
        </td>

        <td>
            Rp <?= number_format($data['total'], 0, ',', '.'); ?>
        </td>

        <td>
            <a href="detail_transaksi.php?id=<?= $data['id']; ?>">
                Lihat Detail
            </a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>
