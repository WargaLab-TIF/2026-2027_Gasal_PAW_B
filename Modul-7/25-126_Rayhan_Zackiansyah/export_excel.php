<?php
include 'koneksi.php';

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="laporan_penjualan.xls"');
?>
<table border="1">
  <tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>
  <?php $no = 1; foreach ($rekap as $row): ?>
  <tr>
    <td><?= $no++; ?></td>
    <td><?= $row['total_harian']; ?></td>
    <td><?= htmlspecialchars($row['tgl']); ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<p>Jumlah Pelanggan: <?= $total_pelanggan; ?> Orang</p>
<p>Jumlah Pendapatan: Rp. <?= number_format($total_pendapatan, 0, ',', '.'); ?></p>
