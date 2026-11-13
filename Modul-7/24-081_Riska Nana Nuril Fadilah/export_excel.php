<?php
require 'koneksi.php';

$mulai = $_GET['tanggal_mulai'] ?? '';
$selesai = $_GET['tanggal_selesai'] ?? '';

$q = "SELECT
        DATE(waktu_transaksi) AS tgl,
        SUM(total) AS total_harian
      FROM transaksi
      WHERE waktu_transaksi BETWEEN '$mulai 00:00:00'
      AND '$selesai 23:59:59'
      GROUP BY DATE(waktu_transaksi)
      ORDER BY tgl ASC";

$res = mysqli_query($conn, $q);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

?>

<h2>Laporan Penjualan</h2>

<table border="1">
    <tr>
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
    </tr>

    <?php
    $no = 1;
    $total_pendapatan = 0;

    while ($row = mysqli_fetch_assoc($res)) {
        $total_pendapatan += $row['total_harian'];
    ?>

    <tr>
        <td><?= $no++ ?></td>

        <td>
            Rp <?= number_format($row['total_harian'], 0, ',', '.') ?>
        </td>

        <td><?= $row['tgl'] ?></td>
    </tr>

    <?php } ?>

    <tr>
        <th colspan="1">Total Pendapatan</th>
        <th colspan="2">
            Rp <?= number_format($total_pendapatan, 0, ',', '.') ?>
        </th>
    </tr>
</table>