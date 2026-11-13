<?php
if (empty($_GET['mulai']) || empty($_GET['selesai'])) {
  die("Pilih rentang tanggal dan tekan Tampilkan dulu sebelum export Excel.");
}
if ($_GET['mulai'] > $_GET['selesai']) {
  die("Tanggal mulai tidak boleh lebih besar dari tanggal selesai.");
}
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=rekap_penjualan.xls");

$koneksi = mysqli_connect("localhost", "root", "", "penjualan");
$mulai = mysqli_real_escape_string($koneksi, $_GET['mulai'] ?? '');
$selesai = mysqli_real_escape_string($koneksi, $_GET['selesai'] ?? '');

$q = "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian
      FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai'
      GROUP BY DATE(waktu_transaksi) ORDER BY tgl ASC";
$res = mysqli_query($koneksi, $q);

$qp = "SELECT COUNT(DISTINCT pelanggan_id) AS jml FROM transaksi
       WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai'";
$pelanggan = mysqli_fetch_assoc(mysqli_query($koneksi, $qp))['jml'] ?? 0;
?>
<h3>Rekap Laporan Penjualan <?= $mulai; ?> sampai <?= $selesai; ?></h3>
<table border="1">
  <tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>
  <?php $no = 1; $total = 0; while ($r = mysqli_fetch_assoc($res)) { $total += $r['total_harian']; ?>
  <tr>
    <td><?= $no++; ?></td>
    <td>Rp. <?= number_format($r['total_harian'], 0, ',', '.'); ?></td>
    <td><?= date('d M Y', strtotime($r['tgl'])); ?></td>
  </tr>
  <?php } ?>
  <tr><td colspan="2"><b>Jumlah Pelanggan</b></td><td><b><?= $pelanggan; ?> Orang</b></td></tr>
  <tr><td colspan="2"><b>Jumlah Pendapatan</b></td><td><b>Rp. <?= number_format($total, 0, ',', '.'); ?></b></td></tr>
</table>