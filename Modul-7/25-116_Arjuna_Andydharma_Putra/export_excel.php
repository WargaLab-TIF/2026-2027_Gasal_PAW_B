<?php
require 'koneksi.php';

$mulai   = $_GET['mulai']   ?? '';
$selesai = $_GET['selesai'] ?? '';

if (!tanggalValid($mulai) || !tanggalValid($selesai) || $mulai > $selesai) {
    die('Rentang tanggal tidak valid.');
}

$laporan = ambilLaporan($koneksi, $mulai, $selesai);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Penjualan_{$mulai}_sd_{$selesai}.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head><meta charset="UTF-8"></head>
<body>
<h3>Rekap Laporan Penjualan <?= htmlspecialchars($mulai) ?> sampai <?= htmlspecialchars($selesai) ?></h3>
<table border="1">
    <tr>
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
    </tr>
    <?php $no = 1; foreach ($laporan['rekap'] as $row): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= (int) $row['total_harian'] ?></td>
        <td><?= htmlspecialchars($row['tgl']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<br>
<table border="1">
    <tr>
        <th>Jumlah Pelanggan Unik</th>
        <th>Total Pendapatan Keseluruhan</th>
    </tr>
    <tr>
        <td><?= $laporan['total_pelanggan'] ?> Orang</td>
        <td><?= $laporan['total_pendapatan'] ?></td>
    </tr>
</table>
</body>
</html>
