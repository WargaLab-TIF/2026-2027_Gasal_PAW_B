<?php
include "validasi.php";
include "koneksi.php";
wajib_login();

$query = mysqli_query($koneksi, "
    SELECT 
        transaksi.*,
        pelanggan.nama_pelanggan AS nama_pelanggan
    FROM transaksi
    LEFT JOIN pelanggan
        ON transaksi.id_pelanggan = pelanggan.id_pelanggan
    ORDER BY transaksi.id_transaksi DESC
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

<a href="index.php">Home</a>

<a href="tambah_transaksi.php" class="btn-tambah">
    + Tambah Transaksi
</a>

<table>
    <tr>
        <th>ID</th>
        <th>Nama Pelanggan</th>
        <th>Tanggal Transaksi</th>
        <th>Total</th>
        <th>Detail</th>
    </tr>

    <?php while ($data = mysqli_fetch_assoc($query)) { ?>
    <tr>
        <td><?= $data['id_transaksi']; ?></td>

        <td>
            <?= htmlspecialchars($data['nama_pelanggan'] ?? '-'); ?>
        </td>

        <td><?= htmlspecialchars($data['tanggal']); ?></td>

        <td>
            Rp <?= number_format($data['total'], 0, ',', '.'); ?>
        </td>

        <td>
            <a href="detail_transaksi.php?id=<?= $data['id_transaksi']; ?>">
                Lihat Detail
            </a>
        </td>
    </tr>
    <?php } ?>

</table>

</body>
</html>
