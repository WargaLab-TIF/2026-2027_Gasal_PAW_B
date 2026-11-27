<?php
require_once "middleware.php";
cekLogin();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan dan Grafik</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .card-container {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        .card {
            border: 1px solid #bce8f1;
            background-color: #d9edf7;
            border-radius: 4px;
            padding: 15px 20px;
            min-width: 220px;
        }
        .card h3 {
            margin: 0 0 8px 0;
            font-size: 14px;
            color: #31708f;
        }
        .card p {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #333;
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
        <a href="index.php">&laquo; Kembali ke Dashboard</a>
        <br><br>
        <h1>Filter Laporan Penjualan</h1>
        <form method="GET">
            Dari: <input type="date" name="mulai" value="<?= $_GET['mulai'] ?? '' ?>" required>
            Sampai: <input type="date" name="selesai" value="<?= $_GET['selesai'] ?? '' ?>" required>
            <button type="submit">Tampilkan</button>
        </form>
        <br>
        <button onclick="window.print()">Cetak</button>
        <a href="export_excel.php?mulai=<?= $_GET['mulai'] ?? '' ?>&selesai=<?= $_GET['selesai'] ?? '' ?>">
            <button type="button">Excel</button>
        </a>
    </div>

    <?php
    $koneksi = mysqli_connect("localhost", "root", "", "penjualan");

    if (mysqli_connect_error()) {
        die("Koneksi database gagal: " . mysqli_connect_error());
    }

    $labels = [];
    $data_total = [];
    $rekap = [];
    $total_pendapatan = 0;
    $total_pelanggan = 0;

    if (!empty($_GET['mulai']) && !empty($_GET['selesai'])) {
        $mulai = $_GET['mulai'];
        $selesai = $_GET['selesai'];

        $q = "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian
              FROM transaksi
              WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'
              GROUP BY DATE(waktu_transaksi)
              ORDER BY tgl ASC";
        $res = mysqli_query($koneksi, $q);

        while ($r = mysqli_fetch_assoc($res)) {
            $labels[] = $r['tgl'];
            $data_total[] = $r['total_harian'];
            $rekap[] = $r;
            $total_pendapatan += $r['total_harian'];
        }

        $qp = "SELECT COUNT(DISTINCT pelanggan_id) AS jml
               FROM transaksi
               WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'";
        $rp = mysqli_fetch_assoc(mysqli_query($koneksi, $qp));
        $total_pelanggan = $rp['jml'] ?? 0;
    }
    ?>

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
                    datasets: [{
                        label: 'Total Penjualan',
                        data: <?= json_encode($data_total); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                }
            });
        </script>

        <h2>Rekapitulasi</h2>
        <table>
            <tr>
                <th>No</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
            <?php
            $no = 1;
            foreach ($rekap as $row):
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td>Rp. <?= number_format($row['total_harian'], 0, ',', '.'); ?></td>
                <td><?= $row['tgl']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="card-container">
            <div class="card">
                <h3>Jumlah Pelanggan</h3>
                <p><?= $total_pelanggan; ?> Orang</p>
            </div>
            <div class="card">
                <h3>Jumlah Pendapatan</h3>
                <p>Rp. <?= number_format($total_pendapatan, 0, ',', '.'); ?></p>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>

