<?php
$koneksi = mysqli_connect("localhost", "root", "", "penjualan");
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$tanggal_mulai   = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

$error = '';
$sudah_tampil = false;
$rekap = [];
$labels = [];
$data_total = [];
$total_pendapatan = 0;
$total_pelanggan = 0;

if ($tanggal_mulai !== '' && $tanggal_selesai !== '') {
    if ($tanggal_mulai > $tanggal_selesai) {
        $error = "Tanggal mulai tidak boleh lebih besar dari tanggal selesai.";
    } else {
        $sudah_tampil = true;

        // 1. Total pendapatan per hari (agregasi SUM + GROUP BY DATE)
        $stmt = mysqli_prepare($koneksi,
            "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian
             FROM transaksi
             WHERE waktu_transaksi BETWEEN ? AND ?
             GROUP BY DATE(waktu_transaksi)
             ORDER BY tgl ASC");
        mysqli_stmt_bind_param($stmt, "ss", $tanggal_mulai, $tanggal_selesai);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        while ($r = mysqli_fetch_assoc($res)) {
            $rekap[]      = $r;
            $labels[]     = $r['tgl'];
            $data_total[] = (int)$r['total_harian'];
            $total_pendapatan += (int)$r['total_harian'];
        }
        mysqli_stmt_close($stmt);

        // 2. Jumlah pelanggan unik (COUNT DISTINCT)
        $stmt = mysqli_prepare($koneksi,
            "SELECT COUNT(DISTINCT pelanggan_id) AS jml
             FROM transaksi
             WHERE waktu_transaksi BETWEEN ? AND ?");
        mysqli_stmt_bind_param($stmt, "ss", $tanggal_mulai, $tanggal_selesai);
        mysqli_stmt_execute($stmt);
        $rp = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
        $total_pelanggan = (int)($rp['jml'] ?? 0);
        mysqli_stmt_close($stmt);
    }
}

$query_excel = http_build_query([
    'tanggal_mulai'   => $tanggal_mulai,
    'tanggal_selesai' => $tanggal_selesai,
]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; color: #222; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #e8f1f8; }
        .btn { padding: 6px 14px; margin-right: 6px; border: none; border-radius: 4px;
               background: #1976d2; color: #fff; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-excel { background: #2e7d32; }
        .card-wrap { display: flex; gap: 16px; margin-top: 20px; }
        .card { flex: 1; border: 1px solid #bbb; border-radius: 6px; padding: 12px; background: #fafafa; }
        .card h3 { margin: 0 0 6px; font-size: 14px; color: #555; }
        .card p { margin: 0; font-size: 20px; font-weight: bold; }
        .error { color: #c62828; }
        .chart-box { width: 100%; max-width: 800px; height: 350px; }

        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <h1>Laporan Penjualan</h1>
    <form method="GET">
        Dari: <input type="date" name="tanggal_mulai" value="<?= htmlspecialchars($tanggal_mulai) ?>" required>
        Sampai: <input type="date" name="tanggal_selesai" value="<?= htmlspecialchars($tanggal_selesai) ?>" required>
        <button type="submit" class="btn">Tampilkan</button>
    </form>

    <?php if ($sudah_tampil): ?>
        <div style="margin-top:12px;">
            <button type="button" class="btn" onclick="window.print()">Cetak</button>
            <a class="btn btn-excel" href="export_excel.php?<?= $query_excel ?>">Excel</a>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</div>

<?php if ($sudah_tampil && !$error): ?>

    <h2>Rekap Laporan Penjualan <?= htmlspecialchars($tanggal_mulai) ?> s/d <?= htmlspecialchars($tanggal_selesai) ?></h2>

    <?php if (empty($rekap)): ?>
        <p>Tidak ada transaksi pada rentang tanggal tersebut.</p>
    <?php else: ?>

        <div class="chart-box">
            <canvas id="grafikPenjualan"></canvas>
        </div>

        <table>
            <tr>
                <th>No</th>
                <th>Total Pendapatan</th>
                <th>Tanggal Transaksi</th>
            </tr>
            <?php $no = 1; foreach ($rekap as $row): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>Rp <?= number_format($row['total_harian'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['tgl']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="card-wrap">
            <div class="card">
                <h3>Jumlah Pelanggan Unik</h3>
                <p><?= $total_pelanggan ?> Orang</p>
            </div>
            <div class="card">
                <h3>Total Pendapatan Keseluruhan</h3>
                <p>Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></p>
            </div>
        </div>

        <script>
            const ctx = document.getElementById('grafikPenjualan').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($labels) ?>,
                    datasets: [{
                        label: 'Total Pendapatan',
                        data: <?= json_encode($data_total) ?>,
                        backgroundColor: 'rgba(25, 118, 210, 0.6)'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { title: { display: true, text: 'Tanggal Transaksi' } },
                        y: { beginAtZero: true, title: { display: true, text: 'Total Pendapatan (Rp)' } }
                    }
                }
            });
        </script>

    <?php endif; ?>

<?php endif; ?>

</body>
</html>
