
<?php
include 'koneksi.php';

// Proses export Excel
if (isset($_GET['export'])) {

    $mulai = $_GET['mulai'] ?? '';
    $selesai = $_GET['selesai'] ?? '';

    if (empty($mulai) || empty($selesai)) {
        die("Tanggal belum dipilih!");
    }

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

    $q = "SELECT DATE(waktu_transaksi) AS tgl,
                 SUM(total) AS total_harian
          FROM transaksi
          WHERE waktu_transaksi >= '$mulai'
          AND waktu_transaksi < DATE_ADD('$selesai', INTERVAL 1 DAY)
          GROUP BY DATE(waktu_transaksi)
          ORDER BY tgl ASC";

    $res = mysqli_query($koneksi, $q);

    $total_pendapatan = 0;
    $no = 1;
    ?>

    <table border="1">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Total Penjualan</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['tgl']; ?></td>
                <td><?= $row['total_harian']; ?></td>
            </tr>

            <?php
            $total_pendapatan += $row['total_harian'];
        } ?>

        <tr>
            <th colspan="2">Total Pendapatan</th>
            <th><?= $total_pendapatan; ?></th>
        </tr>
    </table>

    <?php
    exit;
}

// Mengambil data laporan
$labels = [];
$data_total = [];
$rekap = [];

$total_pendapatan = 0;
$total_pelanggan = 0;

if (!empty($_GET['mulai']) && !empty($_GET['selesai'])) {

    $mulai = $_GET['mulai'];
    $selesai = $_GET['selesai'];

    // Query total pendapatan harian
    $q = "SELECT DATE(waktu_transaksi) AS tgl,
                 SUM(total) AS total_harian
          FROM transaksi
          WHERE waktu_transaksi >= '$mulai'
          AND waktu_transaksi < DATE_ADD('$selesai', INTERVAL 1 DAY)
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
           WHERE waktu_transaksi >= '$mulai'
           AND waktu_transaksi < DATE_ADD('$selesai', INTERVAL 1 DAY)";

    $rp = mysqli_fetch_assoc(mysqli_query($koneksi, $qp));

    $total_pelanggan = $rp['jml'] ?? 0;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penjualan dan Grafik</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f4fa;
            padding: 30px;
            color: #252b40;
        }

        h1, h2 {
            color: #493b78;
        }

        h1 {
            text-align: center;
        }

        h2 {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        }

        th {
            background: #493b78;
            color: white;
            padding: 16px;
        }

        td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #eeeaf5;
        }

        tr:hover {
            background: #f0edfa;
        }

        a {
            display: inline-block;
            color: white;
            background: #8064c8;
            padding: 9px 15px;
            border-radius: 7px;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            background: #6248a5;
        }

        button {
            background: #8064c8;
            color: white;
            border: none;
            padding: 9px 15px;
            border-radius: 7px;
            cursor: pointer;
        }

        input[type="date"] {
            padding: 8px;
            border: 1px solid #8064c8;
            border-radius: 7px;
            color: #493b78;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body>

    <h1>LAPORAN PENJUALAN</h1>

    <div class="no-print">

        <p>
            <a href="index.php">Kembali ke Data Transaksi</a>
        </p>

        <h2>Filter Laporan Penjualan</h2>

        <form method="GET">
            Dari:
            <input type="date" name="mulai"
                value="<?= $_GET['mulai'] ?? '' ?>" required>

            Sampai:
            <input type="date" name="selesai"
                value="<?= $_GET['selesai'] ?? '' ?>" required>

            <button type="submit">Tampilkan</button>
        </form>

        <br>

        <button onclick="window.print()">Cetak</button>

        <a href="?export=1&mulai=<?= $_GET['mulai'] ?? '' ?>&selesai=<?= $_GET['selesai'] ?? '' ?>">
            Excel
        </a>

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
                    datasets: [{
                        label: 'Total Penjualan',
                        data: <?= json_encode($data_total); ?>
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
                    <td>
                        Rp. <?= number_format($row['total_harian'], 0, ',', '.'); ?>
                    </td>
                    <td><?= $row['tgl']; ?></td>
                </tr>
            <?php endforeach; ?>

        </table>

        <p>
            <b>Jumlah Pelanggan:</b>
            <?= $total_pelanggan; ?> Orang |

            <b>Jumlah Pendapatan:</b>
            Rp. <?= number_format($total_pendapatan, 0, ',', '.'); ?>
        </p>

    <?php elseif (!empty($_GET['mulai']) && !empty($_GET['selesai'])): ?>

        <p>Tidak ada data penjualan pada tanggal tersebut.</p>

    <?php endif; ?>

</body>
</html>
