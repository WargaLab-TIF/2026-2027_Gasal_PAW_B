<?php
require_once 'config.php';
wajib_login();

$export = defined('EXPORT');   // true jika dipanggil dari export_excel.php

$mulai   = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

$labels = []; $data_total = []; $rekap = [];
$total_pendapatan = 0; $total_pelanggan = 0;

if ($mulai !== '' && $selesai !== '') {
    // Query agregasi total pendapatan harian
    $s = mysqli_prepare($conn, "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian
        FROM transaksi WHERE waktu_transaksi BETWEEN ? AND ?
        GROUP BY DATE(waktu_transaksi) ORDER BY tgl ASC");
    mysqli_stmt_bind_param($s, 'ss', $mulai, $selesai);
    mysqli_stmt_execute($s);
    $res = mysqli_stmt_get_result($s);
    while ($r = mysqli_fetch_assoc($res)) {
        $labels[] = $r['tgl'];
        $data_total[] = (int)$r['total_harian'];
        $rekap[] = $r;
        $total_pendapatan += $r['total_harian'];
    }

    // Query jumlah pelanggan unik
    $s = mysqli_prepare($conn, "SELECT COUNT(DISTINCT pelanggan_id) AS jml FROM transaksi
        WHERE waktu_transaksi BETWEEN ? AND ?");
    mysqli_stmt_bind_param($s, 'ss', $mulai, $selesai);
    mysqli_stmt_execute($s);
    $rp = mysqli_fetch_assoc(mysqli_stmt_get_result($s));
    $total_pelanggan = $rp['jml'] ?? 0;
}

if (!$export) include 'header.php';
?>
<style>
@media print { .no-print, .navbar { display: none !important; } }
</style>

<?php if (!$export) { ?>
<div class="no-print">
<h3>Filter Laporan Penjualan</h3>
<form method="GET" class="form-inline" style="margin-bottom:10px">
  <div class="form-group">Dari: <input type="date" name="mulai" class="form-control" value="<?= h($mulai) ?>" required></div>
  <div class="form-group">Sampai: <input type="date" name="selesai" class="form-control" value="<?= h($selesai) ?>" required></div>
  <button type="submit" class="btn btn-primary">Tampilkan</button>
  <button type="button" class="btn btn-default" onclick="window.print()">Cetak</button>
  <a class="btn btn-success" href="export_excel.php?mulai=<?= urlencode($mulai) ?>&selesai=<?= urlencode($selesai) ?>">Excel</a>
</form>
</div>
<?php } ?>

<?php if (!empty($labels)): ?>
<?php if (!$export) { ?>
<h3>Grafik Penjualan</h3>
<div style="width: 600px; max-width:100%; height: 300px;"><canvas id="myChart"></canvas></div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('myChart').getContext('2d');
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?= json_encode($labels); ?>,
    datasets: [{ label: 'Total Penjualan', data: <?= json_encode($data_total); ?> }]
  }
});
</script>
<?php } ?>

<h3>Rekapitulasi</h3>
<table class="table table-bordered" border="1">
  <tr><th>No</th><th>Total</th><th>Tanggal</th></tr>
  <?php $no = 1; foreach ($rekap as $row): ?>
  <tr>
    <td><?= $no++; ?></td>
    <td>Rp. <?= number_format($row['total_harian'], 0, ',', '.'); ?></td>
    <td><?= h($row['tgl']); ?></td>
  </tr>
  <?php endforeach; ?>
</table>

<table class="table table-bordered" border="1" style="width:auto">
  <tr><th>Jumlah Pelanggan</th><th>Jumlah Pendapatan</th></tr>
  <tr>
    <td><?= $total_pelanggan; ?> Orang</td>
    <td>Rp. <?= number_format($total_pendapatan, 0, ',', '.'); ?></td>
  </tr>
</table>
<?php elseif ($mulai !== '' && $selesai !== ''): ?>
<div class="alert alert-info">Tidak ada transaksi pada rentang tanggal tersebut.</div>
<?php endif; ?>

<?php if (!$export) include 'footer.php'; ?>
