<?php
require 'koneksi.php';

$mulai = $_GET['tanggal_mulai'] ?? '';
$selesai = $_GET['tanggal_selesai'] ?? '';

$labels = [];
$data_total = [];
$rekap = [];

$total_pendapatan = 0;
$total_pelanggan = 0;

if (!empty($mulai) && !empty($selesai)) {

    $q = "SELECT DATE(waktu_transaksi) AS tgl,
                 SUM(total) AS total_harian
          FROM transaksi
          WHERE waktu_transaksi BETWEEN '$mulai 00:00:00'
          AND '$selesai 23:59:59'
          GROUP BY DATE(waktu_transaksi)
          ORDER BY tgl ASC";

    $res = mysqli_query($conn, $q);

    while ($r = mysqli_fetch_assoc($res)) {
        $labels[] = $r['tgl'];
        $data_total[] = $r['total_harian'];
        $rekap[] = $r;

        $total_pendapatan += $r['total_harian'];
    }

    $qp = "SELECT COUNT(DISTINCT pelanggan_id) AS jml
           FROM transaksi
           WHERE waktu_transaksi BETWEEN '$mulai 00:00:00'
           AND '$selesai 23:59:59'";

    $rp = mysqli_query($conn, $qp);
    $data_pelanggan = mysqli_fetch_assoc($rp);

    $total_pelanggan = $data_pelanggan['jml'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>

    <!-- Library Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial;
            margin: 30px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background: #ddd;
        }

        .no-print {
            margin-bottom: 20px;
        }

        .ringkasan {
            margin-top: 20px;
            padding: 15px;
            background: #eee;
        }

        /* Tambahan CSS untuk Card Ringkasan */
        .isi-ringkasan {
            display: flex;
            gap: 20px;
            margin-top: 15px;
        }

        .item-ringkasan {
            flex: 1;
            padding: 15px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .nilai {
            font-size: 20px;
            font-weight: bold;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <div class="no-print">
        <h1>Laporan Penjualan</h1>

        <form method="GET">
            Tanggal Mulai:
            <input type="date" name="tanggal_mulai"
                   value="<?= htmlspecialchars($mulai) ?>" required>

            Tanggal Selesai:
            <input type="date" name="tanggal_selesai"
                   value="<?= htmlspecialchars($selesai) ?>" required>

            <button type="submit">Tampilkan</button>
        </form>

        <br>

        <button onclick="window.print()">Cetak</button>

        <?php if (!empty($mulai) && !empty($selesai)): ?>
            <a href="export_excel.php?tanggal_mulai=<?= urlencode($mulai) ?>&tanggal_selesai=<?= urlencode($selesai) ?>">
                Excel
            </a>
        <?php endif; ?>
    </div>

    <?php if (!empty($mulai) && !empty($selesai)): ?>

        <h2>Grafik Penjualan</h2>

        <?php if (!empty($labels)): ?>

            <div style="width: 600px; height: 300px;">
                <canvas id="myChart"></canvas>
            </div>

            <script>
                const ctx = document.getElementById('myChart');

                new Chart(ctx, {
                    type: 'bar',

                    data: {
                        labels: <?= json_encode($labels) ?>,

                        datasets: [{
                            label: 'Total Penjualan',
                            data: <?= json_encode($data_total) ?>
                        }]
                    }
                });
            </script>

        <?php else: ?>

            <p>Tidak ada transaksi pada tanggal tersebut.</p>

        <?php endif; ?>

        <h2>Rekapitulasi Penjualan</h2>

        <table>
            <tr>
                <th>No</th>
                <th>Total Pendapatan</th>
                <th>Tanggal Transaksi</th>
            </tr>

            <?php $no = 1; ?>

            <?php foreach ($rekap as $row): ?>

                <tr>
                    <td><?= $no++ ?></td>

                    <td>
                        Rp <?= number_format(
                            $row['total_harian'], 0, ',', '.'
                        ) ?>
                    </td>

                    <td><?= $row['tgl'] ?></td>
                </tr>

            <?php endforeach; ?>
        </table>

        <div class="ringkasan">

            <h3>Total Kumulatif</h3>

            <div class="isi-ringkasan">

                <div class="item-ringkasan">
                    <p>Jumlah Pelanggan:</p>

                    <div class="nilai">
                        <?= $total_pelanggan ?> Orang
                    </div>
                </div>

                <div class="item-ringkasan">
                    <p>Jumlah Pendapatan:</p>

                    <div class="nilai">
                        Rp <?= number_format(
                            $total_pendapatan, 0, ',', '.'
                        ) ?>
                    </div>
                </div>

            </div>

        </div>

    <?php endif; ?>

</body>
</html>