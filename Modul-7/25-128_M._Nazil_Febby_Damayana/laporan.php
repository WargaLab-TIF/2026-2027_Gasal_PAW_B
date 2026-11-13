<?php
require 'koneksi.php';

$tanggal_mulai = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

$rekap = [];
$labels = [];
$data_total = [];

$total_pendapatan = 0;
$total_pelanggan = 0;

if ($tanggal_mulai && $tanggal_selesai) {

    $query = "SELECT DATE(waktu_transaksi) AS tanggal,
              SUM(total) AS total_harian
              FROM transaksi
              WHERE DATE(waktu_transaksi) BETWEEN ? AND ?
              GROUP BY DATE(waktu_transaksi)
              ORDER BY tanggal ASC";

    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ss", $tanggal_mulai, $tanggal_selesai);
    mysqli_stmt_execute($stmt);

    $hasil = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($hasil)) {
        $rekap[] = $row;
        $labels[] = $row['tanggal'];
        $data_total[] = $row['total_harian'];
        $total_pendapatan += $row['total_harian'];
    }

    $query_pelanggan = "SELECT COUNT(DISTINCT pelanggan_id) AS jumlah
                        FROM transaksi
                        WHERE DATE(waktu_transaksi) BETWEEN ? AND ?";

    $stmt = mysqli_prepare($koneksi, $query_pelanggan);
    mysqli_stmt_bind_param($stmt, "ss", $tanggal_mulai, $tanggal_selesai);
    mysqli_stmt_execute($stmt);
    $hasil_pelanggan = mysqli_stmt_get_result($stmt);
    $data_pelanggan = mysqli_fetch_assoc($hasil_pelanggan);
    $total_pelanggan = $data_pelanggan['jumlah'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
<h2>Laporan Penjualan</h2>
<div class="no-print">
    <form method="GET">
        Tanggal Mulai:
        <input type="date" name="tanggal_mulai"value="<?= htmlspecialchars($tanggal_mulai) ?>" required>
        Tanggal Selesai:
        <input type="date" name="tanggal_selesai"value="<?= htmlspecialchars($tanggal_selesai) ?>" required>
        <button type="submit">Tampilkan</button>
    </form>
    <br>
    <button onclick="window.print()">Cetak</button>
    <a href="export_excel.php?tanggal_mulai=<?= $tanggal_mulai ?>&tanggal_selesai=<?= $tanggal_selesai ?>">
        <button type="button">Export Excel</button>
    </a>
</div>

<?php if ($tanggal_mulai && $tanggal_selesai): ?>
    <h3>Grafik Penjualan</h3>

    <canvas id="grafik" width="600" height="250"></canvas>

    <h3>Rekapitulasi Penjualan</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Total Pendapatan</th>
            <th>Tanggal Transaksi</th>
        </tr>

        <?php if (count($rekap) > 0): ?>
            <?php $no = 1; ?>

            <?php foreach ($rekap as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>Rp <?= number_format($row['total_harian'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['tanggal']) ?></td>
                </tr>
            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="3">Tidak ada data penjualan.</td>
            </tr>
        <?php endif; ?>
    </table>

    <h3>Ringkasan Total</h3>
    <p>Jumlah Pelanggan Unik: <?= $total_pelanggan ?> Orang</p>
    <p>Total Pendapatan: Rp <?= number_format($total_pendapatan, 0, ',', '.') ?>
    </p>
<?php endif; ?>

<script>
new Chart(document.getElementById('grafik'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Total Penjualan',
            data: <?= json_encode($data_total) ?>
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

</body>
</html>