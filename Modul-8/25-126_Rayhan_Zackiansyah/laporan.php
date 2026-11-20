
<?php
include 'koneksi.php';
wajib_login();

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';
$rekap = [];
$labels = [];
$data_total = [];
$total_pendapatan = 0;
$total_pelanggan = 0;
$pesan = '';

if ($mulai != '' && $selesai != '') {
  if ($mulai > $selesai || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $mulai) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $selesai)) {
    $pesan = 'Rentang tanggal tidak valid.';
  } else {
    $awal = $mulai . ' 00:00:00';
    $akhir = date('Y-m-d', strtotime($selesai . ' +1 day')) . ' 00:00:00';

    $sql = "SELECT DATE(waktu_transaksi) AS tanggal,
            SUM(total) AS pendapatan
            FROM transaksi
            WHERE waktu_transaksi >= ? AND waktu_transaksi < ?
            GROUP BY DATE(waktu_transaksi)
            ORDER BY tanggal";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $awal, $akhir);
    mysqli_stmt_execute($stmt);
    $hasil = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($hasil)) {
      $rekap[] = $row;
      $labels[] = $row['tanggal'];
      $data_total[] = $row['pendapatan'];
      $total_pendapatan += $row['pendapatan'];
    }

    $sql2 = "SELECT COUNT(DISTINCT pelanggan_id) AS jumlah
             FROM transaksi
             WHERE waktu_transaksi >= ? AND waktu_transaksi < ?";

    $stmt2 = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt2, 'ss', $awal, $akhir);
    mysqli_stmt_execute($stmt2);
    $hitung = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt2));
    $total_pelanggan = $hitung['jumlah'];
  }
}

if (isset($_GET['excel']) && $pesan == '' && $mulai != '' && $selesai != '') {
  header('Content-Type: application/vnd.ms-excel; charset=utf-8');
  header('Content-Disposition: attachment; filename="laporan_penjualan.xls"');

  echo '<table border="1">';
  echo '<tr><th>No</th><th>Tanggal</th><th>Total Pendapatan</th></tr>';

  $no = 1;
  foreach ($rekap as $row) {
    echo '<tr>';
    echo '<td>' . $no++ . '</td>';
    echo '<td>' . htmlspecialchars($row['tanggal']) . '</td>';
    echo '<td>' . $row['pendapatan'] . '</td>';
    echo '</tr>';
  }

  echo '</table>';
  echo '<p>Jumlah Pelanggan Unik: ' . $total_pelanggan . '</p>';
  echo '<p>Total Pendapatan: ' . $total_pendapatan . '</p>';
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan Penjualan</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="no-print">
  <?php menu(); ?>
</div>

<h2>Laporan Penjualan</h2>

<div class="no-print pencarian">
  <form method="get">
    Dari:
    <input type="date" name="mulai" value="<?= htmlspecialchars($mulai); ?>" required>

    Sampai:
    <input type="date" name="selesai" value="<?= htmlspecialchars($selesai); ?>" required>

    <button type="submit">Tampilkan</button>
  </form>

  <?php if ($mulai != '' && $selesai != '' && $pesan == '') { ?>
    <button onclick="window.print()">Print</button>
    <a href="laporan.php?mulai=<?= urlencode($mulai); ?>&amp;selesai=<?= urlencode($selesai); ?>&amp;excel=1">Export Excel</a>
  <?php } ?>
</div>

<?php if ($pesan != '') { ?>

  <p class="pesan"><?= htmlspecialchars($pesan); ?></p>

<?php } elseif ($mulai != '' && $selesai != '') { ?>

  <p>Periode: <?= htmlspecialchars($mulai); ?> sampai <?= htmlspecialchars($selesai); ?></p>

  <h3>Grafik Pendapatan Harian</h3>

  <div style="max-width: 750px; margin-bottom: 25px;">
    <canvas id="myChart"></canvas>
  </div>

  <h3>Rekap Pendapatan Harian</h3>

  <table>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Total Pendapatan</th>
    </tr>

    <?php $no = 1; foreach ($rekap as $row) { ?>
      <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($row['tanggal']); ?></td>
        <td>Rp <?= number_format($row['pendapatan'], 0, ',', '.'); ?></td>
      </tr>
    <?php } ?>

    <?php if (count($rekap) == 0) { ?>
      <tr>
        <td colspan="3">Belum ada transaksi dalam periode ini.</td>
      </tr>
    <?php } ?>
  </table>

  <h3>Ringkasan</h3>

  <p>Jumlah Pelanggan Unik: <b><?= $total_pelanggan; ?> orang</b></p>
  <p>Total Pendapatan: <b>Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?></b></p>

  <script>
    const ctx = document.getElementById('myChart').getContext('2d');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?= json_encode($labels); ?>,
        datasets: [{
          label: 'Total Penjualan',
          data: <?= json_encode($data_total, JSON_NUMERIC_CHECK); ?>,
          backgroundColor: 'rgba(54, 162, 235, 0.7)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>

<?php } else { ?>

  <p>Pilih tanggal mulai dan selesai, lalu klik Tampilkan.</p>

<?php } ?>

</body>
</html>
