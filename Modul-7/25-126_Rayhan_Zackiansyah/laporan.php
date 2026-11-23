<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan Penjualan</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    table { border-collapse: collapse; width: 100%; margin-top: 15px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    @media print { .no-print { display: none !important; } }
  </style>
</head>
<body>
  <div class="no-print">
    <h1>Filter Laporan Penjualan</h1>
    <form method="GET">
      Dari: <input type="date" name="mulai" value="<?= htmlspecialchars($_GET['mulai'] ?? '') ?>" required>
      Sampai: <input type="date" name="selesai" value="<?= htmlspecialchars($_GET['selesai'] ?? '') ?>" required>
      <button type="submit" style="background: blue; color: white;">Tampilkan</button>
    </form>
    <br>
    <button onclick="window.print()" style="background: #475569; color: white; ">Cetak/Print</button>
    <a href="export_excel.php?mulai=<?= urlencode($_GET['mulai'] ?? '') ?>&selesai=<?= urlencode($_GET['selesai'] ?? '') ?>">
      <button type="button" style="background: #15803D; color: white;">Excel</button></a>
  </div>

  <?php if (!empty($labels)): ?>
    <h2>Grafik Penjualan</h2>
    <div style="width: 600px; height: 300px;">
      <canvas id="myChart"></canvas>
    </div>
    <script>
      const ctx = document.getElementById('myChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: <?= json_encode($labels); ?>,
          datasets: [{ label: 'Total Penjualan', data: <?= json_encode($data_total, JSON_NUMERIC_CHECK); ?>, }]
        }
      });
    </script>
    <hr>
    <h2>Rekapitulasi</h2>
    <table style="width: 600px;">
      <tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>
      <?php $no = 1; foreach ($rekap as $row): ?>
      <tr>
        <td><?= $no++; ?></td>
        <td>Rp. <?= number_format($row['total_harian'], 0, ',', '.'); ?></td>
        <td><?= htmlspecialchars($row['tgl']); ?></td>
      </tr>
      <?php endforeach; ?>
    </table>

<h2>Ringkasan Penjualan</h2>

<table style="width: 400px;">
  <tr>
    <th>Jumlah Pelanggan Unik</th>
    <th>Total Pendapatan Keseluruhan</th>
  </tr>
  <tr>
    <td><?= $total_pelanggan; ?> Orang</td>
    <td>Rp. <?= number_format($total_pendapatan, 0, ',', '.'); ?></td>
  </tr>
</table>
  <?php elseif (!empty($_GET['mulai']) && !empty($_GET['selesai'])): ?>
    <p>Tidak ada transaksi pada rentang tanggal tersebut.</p>
  <?php endif; ?>
</body>
</html>
