
<?php
require_once "koneksi.php";

// Query data transaksi
$query = "
    SELECT
        t.id,
        t.waktu_transaksi,
        t.keterangan,
        t.total,
        p.nama AS nama_pelanggan
    FROM transaksi t
    JOIN pelanggan p ON p.id = t.pelanggan_id
    ORDER BY t.id DESC
";

$result = mysqli_query($koneksi, $query);

// Data laporan
$labels = [];
$data_total = [];
$rekap = [];

$total_pendapatan = 0;
$total_pelanggan = 0;

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

if ($mulai != '' && $selesai != '') {

    // Query pendapatan harian
    $q = "SELECT
              DATE(waktu_transaksi) AS tgl,
              SUM(total) AS total_harian
          FROM transaksi
          WHERE waktu_transaksi >= '$mulai 00:00:00'
          AND waktu_transaksi <= '$selesai 23:59:59'
          GROUP BY DATE(waktu_transaksi)
          ORDER BY tgl ASC";

    $res = mysqli_query($koneksi, $q);

    while ($r = mysqli_fetch_assoc($res)) {

        $labels[] = $r['tgl'];
        $data_total[] = $r['total_harian'];
        $rekap[] = $r;

        $total_pendapatan += $r['total_harian'];
    }

    // Query jumlah pelanggan unik
    $qp = "SELECT COUNT(DISTINCT pelanggan_id) AS jml
           FROM transaksi
           WHERE waktu_transaksi >= '$mulai 00:00:00'
           AND waktu_transaksi <= '$selesai 23:59:59'";

    $rp = mysqli_fetch_assoc(mysqli_query($koneksi, $qp));

    $total_pelanggan = $rp['jml'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Transaksi dan Laporan Penjualan</title>

    <link rel="stylesheet" href="style.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <header class="page-header">

        <div>
            <p class="eyebrow">APLIKASI PENJUALAN</p>
            <h1>Data Transaksi</h1>
            <p class="subtitle">
                Daftar transaksi dan laporan penjualan pelanggan.
            </p>
        </div>

        <nav class="nav">
            <a href="index.php" class="nav-link active">Transaksi</a>
            <a href="barang.php" class="nav-link">Data Barang</a>
        </nav>

    </header>

    <!-- TABEL TRANSAKSI -->
    <section class="panel">

        <div class="panel-heading">
            <div>
                <h2>Daftar Transaksi</h2>
                <p class="muted">
                    Pilih detail untuk melihat rincian transaksi.
                </p>
            </div>
        </div>

        <div class="table-wrap">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Keterangan</th>
                        <th class="text-right">Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (mysqli_num_rows($result) > 0): ?>

                    <?php while ($row = mysqli_fetch_assoc($result)): ?>

                    <tr>
                        <td>#<?= $row['id']; ?></td>

                        <td>
                            <?= htmlspecialchars($row['waktu_transaksi']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['nama_pelanggan']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['keterangan'] ?? '-'); ?>
                        </td>

                        <td class="text-right">
                            Rp <?= number_format($row['total'], 0, ',', '.'); ?>
                        </td>

                        <td>
                            <a class="button button-small"
                               href="detail.php?id=<?= $row['id']; ?>">
                                Detail
                            </a>
                        </td>
                    </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="6" class="empty">
                            Belum ada data transaksi.
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>
            </table>

        </div>

    </section>

    <!-- LAPORAN PENJUALAN -->
    <section class="panel">

        <div class="no-print">

            <h1>Filter Laporan Penjualan</h1>

            <form method="GET" class="filter-form">

                <div class="filter-group">
                    <label>Dari Tanggal</label>

                    <input type="date"
                           name="mulai"
                           value="<?= htmlspecialchars($mulai); ?>"
                           required>
                </div>

                <div class="filter-group">
                    <label>Sampai Tanggal</label>

                    <input type="date"
                           name="selesai"
                           value="<?= htmlspecialchars($selesai); ?>"
                           required>
                </div>

                <button type="submit" class="button btn-filter">
                    Tampilkan
                </button>

            </form>

            <div class="report-buttons">

                <button onclick="window.print()"
                        class="button btn-print">
                    Cetak
                </button>

                <a href="export_excel.php?mulai=<?= urlencode($mulai); ?>&selesai=<?= urlencode($selesai); ?>"
                   class="button btn-excel">
                    Excel
                </a>

            </div>

        </div>

        <?php if ($mulai != '' && $selesai != ''): ?>

            <?php if (!empty($labels)): ?>

                <!-- GRAFIK -->
                <div class="chart-section">

                    <h2>Grafik Penjualan</h2>

                    <div class="chart-container">
                        <canvas id="myChart"></canvas>
                    </div>

                </div>

                <!-- TABEL REKAP -->
                <div class="rekap-section">

                    <h2>Rekapitulasi Penjualan</h2>

                    <div class="table-wrap">

                        <table class="rekap-table">

                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Total Penjualan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php
                            $no = 1;

                            foreach ($rekap as $row):
                            ?>

                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td>
                                        Rp <?= number_format(
                                            $row['total_harian'],
                                            0,
                                            ',',
                                            '.'
                                        ); ?>
                                    </td>

                                    <td><?= $row['tgl']; ?></td>
                                </tr>

                            <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- RINGKASAN -->
                <div class="report-summary">

                    <b>Jumlah Pelanggan:</b>
                    <?= $total_pelanggan; ?> Orang

                    <br>

                    <b>Jumlah Pendapatan:</b>
                    Rp <?= number_format(
                        $total_pendapatan,
                        0,
                        ',',
                        '.'
                    ); ?>

                </div>

                <!-- CHART JS -->
                <script>

                    const ctx = document.getElementById('myChart');

                    new Chart(ctx, {
                        type: 'bar',

                        data: {
                            labels: <?= json_encode($labels); ?>,

                            datasets: [{
                                label: 'Total Penjualan',
                                data: <?= json_encode($data_total); ?>,
                                backgroundColor: '#6254d9',
                                borderRadius: 6
                            }]
                        },

                        options: {
                            responsive: true,
                            maintainAspectRatio: false,

                            plugins: {
                                legend: {
                                    display: true
                                }
                            },

                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                </script>

            <?php else: ?>

                <div class="empty">
                    Tidak ada data penjualan pada rentang tanggal tersebut.
                </div>

            <?php endif; ?>

        <?php endif; ?>

    </section>

</div>

</body>
</html>
