<?php
$mulai = $_GET['tanggal_mulai'] ?? '';
$selesai = $_GET['tanggal_selesai'] ?? '';

if (empty($mulai) || empty($selesai)) {
  die("Rentang tanggal tidak ditentukan.");
}


$koneksi = mysqli_connect("localhost", "root", "", "penjualan");
if (mysqli_connect_error()) {
  die("Koneksi database gagal: " . mysqli_connect_error());
}

$mulai_clean = mysqli_real_escape_string($koneksi, $mulai);
$selesai_clean = mysqli_real_escape_string($koneksi, $selesai);


$q = "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian
      FROM transaksi 
      WHERE DATE(waktu_transaksi) BETWEEN '$mulai_clean' AND '$selesai_clean'
      GROUP BY DATE(waktu_transaksi) 
      ORDER BY tgl ASC";
$res = mysqli_query($koneksi, $q);


$qp = "SELECT COUNT(DISTINCT pelanggan_id) AS jml FROM transaksi
       WHERE DATE(waktu_transaksi) BETWEEN '$mulai_clean' AND '$selesai_clean'";
$res_p = mysqli_query($koneksi, $qp);
$total_pelanggan = 0;
if ($rp = mysqli_fetch_assoc($res_p)) {
  $total_pelanggan = $rp['jml'] ?? 0;
}

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=rekap_penjualan_" . $mulai . "_sampai_" . $selesai . ".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<h3>Rekap Laporan Penjualan <?= htmlspecialchars($mulai); ?> sampai <?= htmlspecialchars($selesai); ?></h3>
<table border="1">
  <thead>
    <tr style="background-color: #eee;">
      <th>No</th>
      <th>Total Pendapatan</th>
      <th>Tanggal Transaksi</th>
    </tr>
  </thead>
  <tbody>
    <?php 
    $no = 1; 
    $total_pendapatan = 0; 
    while ($r = mysqli_fetch_assoc($res)): 
      $total_pendapatan += $r['total_harian'];
    ?>
    <tr>
      <td><?= $no++; ?></td>
      <td>Rp. <?= number_format($r['total_harian'], 0, ',', '.'); ?></td>
      <td><?= $r['tgl']; ?></td>
    </tr>
    <?php endwhile; ?>
    <tr>
      <td colspan="2"><b>Total Pendapatan Keseluruhan</b></td>
      <td><b>Rp. <?= number_format($total_pendapatan, 0, ',', '.'); ?></b></td>
    </tr>
    <tr>
      <td colspan="2"><b>Jumlah Pelanggan Unik</b></td>
      <td><b><?= $total_pelanggan; ?> Orang</b></td>
    </tr>
  </tbody>
</table>
