<?php
require_once 'auth.php';
require_login();
require_once 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Penjualan dan Grafik</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; width: 100%; margin-top: 15px; }
    th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    th { background-color: #eee; }
    
    .card-container { display: flex; gap: 15px; margin-top: 20px; }
    .card { border: 1px solid #333; padding: 12px 18px; border-radius: 4px; min-width: 180px; background: #fafafa; }
    .card h4 { margin: 0 0 6px 0; color: #555; font-size: 14px; font-weight: normal; }
    .card p { margin: 0; font-size: 18px; font-weight: bold; color: #111; }


    @media print {
      .no-print { display: none !important; }
      body { margin: 0; }
    }
  .app-nav{display:flex;align-items:center;flex-wrap:wrap;gap:5px;margin-bottom:20px}.app-nav a{display:inline-block;background:cadetblue;color:white;text-decoration:none;padding:8px 12px;border-radius:5px}.user-info{margin:5px 10px}
  </style>
</head>
<body>
<?php app_nav(); ?>
  <div class="no-print">
    <h1>Filter Laporan Penjualan</h1>
    <form method="GET">
      Dari: <input type="date" name="tanggal_mulai" value="<?= htmlspecialchars($_GET['tanggal_mulai'] ?? '') ?>" required>
      Sampai: <input type="date" name="tanggal_selesai" value="<?= htmlspecialchars($_GET['tanggal_selesai'] ?? '') ?>" required>
      <button type="submit">Tampilkan</button>
    </form>
    <br>
    <?php if (!empty($_GET['tanggal_mulai']) && !empty($_GET['tanggal_selesai'])): ?>
      <button onclick="window.print()">Cetak</button>
      <a href="excel.php?tanggal_mulai=<?= urlencode($_GET['tanggal_mulai']) ?>&tanggal_selesai=<?= urlencode($_GET['tanggal_selesai']) ?>"><button type="button">Excel</button></a>
    <?php endif; ?>
  </div>

<?php
require_once 'auth.php';
require_login();
require_once 'koneksi.php';

$koneksi = $conn;

$labels = [];
$data_total = [];
$rekap = [];
$total_pendapatan = 0;
$total_pelanggan = 0;

if (!empty($_GET['tanggal_mulai']) && !empty($_GET['tanggal_selesai'])) {
  $mulai = mysqli_real_escape_string($koneksi, $_GET['tanggal_mulai']);
  $selesai = mysqli_real_escape_string($koneksi, $_GET['tanggal_selesai']);


  $q = "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian
        FROM transaksi 
        WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'
        GROUP BY DATE(waktu_transaksi) 
        ORDER BY tgl ASC";
  $res = mysqli_query($koneksi, $q);
  while ($r = mysqli_fetch_assoc($res)) {
    $labels[] = $r['tgl'];
    $data_total[] = (int)$r['total_harian'];
    $rekap[] = $r;
    $total_pendapatan += $r['total_harian'];
  }


  $qp = "SELECT COUNT(DISTINCT pelanggan_id) AS jml FROM transaksi
         WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'";
  $res_p = mysqli_query($koneksi, $qp);
  if ($rp = mysqli_fetch_assoc($res_p)) {
    $total_pelanggan = $rp['jml'] ?? 0;
  }
}
?>

<?php if (!empty($labels)): ?>
  <h2>Grafik Penjualan</h2>
  <div style="width: 100%; max-width: 650px; height: 320px;">
    <canvas id="myChart"></canvas>
  </div>
  <script>
    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?= json_encode($labels); ?>,
        datasets: [{
          label: 'Total Penjualan (Rp)',
          data: <?= json_encode($data_total); ?>,
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });
  </script>

  <h2>Tabel Rekapitulasi</h2>
  <table>
    <thead>
      <tr>
        <th style="width: 50px;">No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($rekap as $row): ?>
      <tr>
        <td><?= $no++; ?></td>
        <td>Rp. <?= number_format($row['total_harian'], 0, ',', '.'); ?></td>
        <td><?= date('d M Y', strtotime($row['tgl'])); ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  
  <div class="card-container">
    <div class="card">
      <h4>Jumlah Pelanggan</h4>
      <p><?= $total_pelanggan; ?> Orang</p>
    </div>
    <div class="card">
      <h4>Jumlah Pendapatan</h4>
      <p>Rp. <?= number_format($total_pendapatan, 0, ',', '.'); ?></p>
    </div>
  </div>

<?php elseif (isset($_GET['tanggal_mulai'])): ?>
  <p><i>Tidak ada data transaksi pada rentang tanggal yang dipilih.</i></p>
<?php endif; ?>

</body>
</html>
