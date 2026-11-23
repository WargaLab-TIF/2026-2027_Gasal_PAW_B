<?php
require 'koneksi.php';

$mulai   = $_GET['mulai']   ?? '';
$selesai = $_GET['selesai'] ?? '';
$error   = '';
$tampil  = false;

$labels = []; $data_total = []; $rekap = [];
$total_pendapatan = 0; $total_pelanggan = 0;

if ($mulai !== '' && $selesai !== '') {
    if (!tanggalValid($mulai) || !tanggalValid($selesai)) {
        $error = 'Format tanggal tidak valid.';
    } elseif ($mulai > $selesai) {
        $error = 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai.';
    } else {
        $tampil  = true;
        $laporan = ambilLaporan($koneksi, $mulai, $selesai);
        $rekap   = $laporan['rekap'];
        $total_pendapatan = $laporan['total_pendapatan'];
        $total_pelanggan  = $laporan['total_pelanggan'];
        foreach ($rekap as $r) {
            $labels[]     = $r['tgl'];
            $data_total[] = (int) $r['total_harian'];
        }
    }
}

function rupiah($n) { return 'Rp. ' . number_format($n, 0, ',', '.'); }
function tglIndo($tgl) {
    $bulan = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    [$y, $m, $d] = explode('-', $tgl);
    return $d . ' ' . $bulan[(int) $m] . ' ' . $y;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laporan Penjualan dan Grafik</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    body { font-family: Arial, sans-serif; margin: 24px; color: #222; }
    h1 { font-size: 24px; color: #2a6fb0; font-weight: normal; }
    h1 small { font-size: 14px; color: #666; }
    h2 { font-size: 18px; margin-top: 28px; }
    form { margin-bottom: 12px; }
    input[type=date] { padding: 6px; }
    button, .btn { padding: 7px 14px; border: 0; border-radius: 4px; cursor: pointer;
                   color: #fff; background: #2a6fb0; font-size: 14px; text-decoration: none; display: inline-block; }
    .btn-cetak, .btn-excel { background: #e8651a; }
    .alert { background: #fdecea; color: #b71c1c; padding: 10px 14px; border-radius: 4px; margin: 12px 0; }
    .info  { background: #fff8e1; color: #6d5600; padding: 10px 14px; border-radius: 4px; margin: 12px 0; }
    .chart-box { width: 100%; max-width: 800px; height: 320px; }
    table { border-collapse: collapse; width: 100%; margin-top: 15px; }
    th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    th { background: #d9ecf7; }
    td.num { text-align: right; }
    .card { display: inline-block; margin-top: 16px; border: 1px solid #000; min-width: 260px; }
    .card div { padding: 6px 12px; }
    .card .judul { background: #d9ecf7; border-bottom: 1px solid #000; font-weight: bold; }
    .card table { margin: 0; }
    .card th, .card td { border: 1px solid #000; }
    @media print {
        .no-print { display: none !important; }
        body { margin: 0; }
    }
</style>
</head>
<body>

<div class="no-print">
    <h1>Filter Laporan Penjualan</h1>
    <form method="GET">
        Dari: <input type="date" name="mulai" value="<?= htmlspecialchars($mulai) ?>" required>
        Sampai: <input type="date" name="selesai" value="<?= htmlspecialchars($selesai) ?>" required>
        <button type="submit">Tampilkan</button>
    </form>

    <?php if ($tampil && !empty($rekap)): ?>
        <button class="btn-cetak" onclick="window.print()">Cetak</button>
        <a class="btn btn-excel"
           href="export_excel.php?mulai=<?= urlencode($mulai) ?>&selesai=<?= urlencode($selesai) ?>">Excel</a>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</div>

<?php if ($tampil): ?>
    <h1>Rekap Laporan Penjualan
        <small><?= htmlspecialchars($mulai) ?> sampai <?= htmlspecialchars($selesai) ?></small>
    </h1>

    <?php if (empty($rekap)): ?>
        <div class="info">Tidak ada transaksi pada rentang tanggal tersebut.</div>
    <?php else: ?>

        <h2>Grafik Penjualan</h2>
        <div class="chart-box"><canvas id="myChart"></canvas></div>
        <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($labels) ?>,
                    datasets: [{
                        label: 'Total Penjualan',
                        data: <?= json_encode($data_total) ?>,
                        backgroundColor: 'rgba(42, 111, 176, 0.6)',
                        borderColor: 'rgba(42, 111, 176, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false, // supaya grafik langsung tampil saat dicetak
                    scales: {
                        x: { title: { display: true, text: 'Tanggal Transaksi' } },
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Total Pendapatan (Rp)' },
                            ticks: { callback: v => v.toLocaleString('id-ID') }
                        }
                    }
                }
            });
        </script>

        <h2>Rekapitulasi</h2>
        <table>
            <tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>
            <?php $no = 1; foreach ($rekap as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= rupiah($row['total_harian']) ?></td>
                <td><?= tglIndo($row['tgl']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="card">
            <table>
                <tr><th>Jumlah Pelanggan</th><th>Jumlah Pendapatan</th></tr>
                <tr>
                    <td class="num"><?= $total_pelanggan ?> Orang</td>
                    <td class="num"><?= rupiah($total_pendapatan) ?></td>
                </tr>
            </table>
        </div>

    <?php endif; ?>
<?php endif; ?>

</body>
</html>
