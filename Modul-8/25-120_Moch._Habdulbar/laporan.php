<?php
require 'config.php';
wajib_login();
$dari   = $_GET['dari'] ?? '';
$sampai = $_GET['sampai'] ?? '';

$sql = "SELECT t.*, p.nama AS pelanggan FROM transaksi t JOIN pelanggan p ON p.id=t.pelanggan_id WHERE 1=1";
$tipe = ''; $par = [];
if ($dari !== '')   { $sql .= " AND t.waktu_transaksi >= ?"; $tipe .= 's'; $par[] = $dari; }
if ($sampai !== '') { $sql .= " AND t.waktu_transaksi <= ?"; $tipe .= 's'; $par[] = $sampai; }
$sql .= " ORDER BY t.waktu_transaksi, t.id";
$s = mysqli_prepare($conn, $sql);
if ($par) mysqli_stmt_bind_param($s, $tipe, ...$par);
mysqli_stmt_execute($s);
$hasil = mysqli_stmt_get_result($s);

include 'header.php';
?>
<h3>Laporan Penjualan</h3>
<form method="get" class="form-inline" style="margin-bottom:15px">
  <div class="form-group"><label>Dari</label> <input type="date" name="dari" class="form-control" value="<?= h($dari) ?>"></div>
  <div class="form-group"><label>Sampai</label> <input type="date" name="sampai" class="form-control" value="<?= h($sampai) ?>"></div>
  <button class="btn btn-primary">Tampilkan</button>
  <a href="laporan.php" class="btn btn-default">Reset</a>
</form>
<table class="table table-bordered table-striped">
  <tr><th>No</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total</th></tr>
  <?php $grand = 0; $n = 0;
  while ($r = mysqli_fetch_assoc($hasil)) { $grand += $r['total']; $n++; ?>
  <tr><td><?= $r['id'] ?></td><td><?= h($r['waktu_transaksi']) ?></td><td><?= h($r['pelanggan']) ?></td><td><?= h($r['keterangan']) ?></td><td><?= rp($r['total']) ?></td></tr>
  <?php } if (!$n) { ?><tr><td colspan="5" class="text-center">Tidak ada data.</td></tr><?php } ?>
  <tr><th colspan="4" class="text-right">Total Penjualan</th><th><?= rp($grand) ?></th></tr>
</table>
<?php include 'footer.php'; ?>
