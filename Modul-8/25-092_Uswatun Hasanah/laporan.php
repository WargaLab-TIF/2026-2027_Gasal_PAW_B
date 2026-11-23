<?php
require_once 'auth.php';
cekLogin();

include 'koneksi.php';

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';
$excel = isset($_GET['excel']);

$labels = [];
$data_total = [];
$rekap = [];

$total_pendapatan = 0;
$total_pelanggan = 0;

if (!empty($mulai) && !empty($selesai)) {

    $mulai = mysqli_real_escape_string($conn, $mulai);
    $selesai = mysqli_real_escape_string($conn, $selesai);

    $q = "SELECT DATE(waktu_transaksi) AS tgl,
                 SUM(total) AS total_harian
          FROM transaksi
          WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'
          GROUP BY DATE(waktu_transaksi)
          ORDER BY tgl ASC";

    $res = mysqli_query($conn, $q);

    if (!$res) {
        die("Query gagal: " . mysqli_error($conn));
    }

    while ($r = mysqli_fetch_assoc($res)) {
        $labels[] = $r['tgl'];
        $data_total[] = $r['total_harian'];
        $rekap[] = $r;

        $total_pendapatan += $r['total_harian'];
    }

    // Query jumlah pelanggan unik
    $qp = "SELECT COUNT(DISTINCT pelanggan_id) AS jml
           FROM transaksi
           WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'";

    $rp = mysqli_fetch_assoc(mysqli_query($conn, $qp));

    $total_pelanggan = $rp['jml'] ?? 0;
}

// EXPORT EXCEL
if ($excel) {

    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=laporan.xls");

    echo "<table border='1'>";
    echo "<tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Total Penjualan</th>
          </tr>";

    $no = 1;

    foreach ($rekap as $row) {
        echo "<tr>
                <td>$no</td>
                <td>{$row['tgl']}</td>
                <td>{$row['total_harian']}</td>
              </tr>";
        $no++;
    }

    echo "<tr>
            <th colspan='2'>Total Pendapatan</th>
            <th>$total_pendapatan</th>
          </tr>";

    echo "<tr>
            <th colspan='2'>Jumlah Pelanggan</th>
            <th>$total_pelanggan</th>
          </tr>";

    echo "</table>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: #fff5f8;
            color: #444;
            font-family: Arial;
            margin: 30px;
            padding: 20px;
            line-height: 1.6;
        }

        h2 {
            color: #d63384;
        }

        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        input {
            padding: 8px;
            border: 1px solid #edb5cd;
            border-radius: 5px;
            margin: 5px;
        }

        button, .btn {
            background: #e879a9;
            color: white;
            padding: 9px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px 3px;
            font-size: 14px;
        }

        button:hover, .btn:hover {
            background: #d63384;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th {
            background: #e879a9;
            color: white;
        }

        th, td {
            border: 1px solid #f5d5e3;
            padding: 10px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #fff0f5;
        }

        .no-print {
            display: block;
        }

        @media print {
            body {
                background: white;
                margin: 0;
                padding: 10px;
            }

            .no-print {
                display: none !important;
            }

            .container {
                padding: 0;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Laporan Penjualan dan Grafik</h2>

    <div class="no-print">

        <h2>Filter Laporan Penjualan</h2>

        <form method="GET">
            Dari:
            <input type="date" name="mulai"
                value="<?= htmlspecialchars($mulai) ?>" required>

            Sampai:
            <input type="date" name="selesai"
                value="<?= htmlspecialchars($selesai) ?>" required>

            <button type="submit">Tampilkan</button>
        </form>

        <?php if (!empty($mulai) && !empty($selesai)) { ?>

            <button onclick="window.print()">Cetak</button>

            <a href="laporan.php?mulai=<?= urlencode($mulai) ?>&selesai=<?= urlencode($selesai) ?>&excel=1">
                <button type="button">Excel</button>
            </a>

        <?php } ?>

    </div>

    <?php if (!empty($mulai) && !empty($selesai)) { ?>

        <h2>Periode Laporan</h2>

        <p>
            Dari <?= htmlspecialchars($mulai) ?>
            sampai <?= htmlspecialchars($selesai) ?>
        </p>

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
                            backgroundColor: '#e879a9',
                            borderColor: '#d63384',
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

                        <td>
                            Rp. <?= number_format(
                                $row['total_harian'],
                                0,
                                ',',
                                '.'
                            ); ?>
                        </td>

                        <td><?= htmlspecialchars($row['tgl']); ?></td>
                    </tr>

                <?php endforeach; ?>

            </table>

            <p>
                <b>Jumlah Pelanggan:</b>
                <?= $total_pelanggan; ?> Orang |

                <b>Jumlah Pendapatan:</b>
                Rp. <?= number_format(
                    $total_pendapatan,
                    0,
                    ',',
                    '.'
                ); ?>
            </p>

        <?php else: ?>

            <p>Tidak ada transaksi pada periode tersebut.</p>

        <?php endif; ?>

    <?php } ?>

</div>

</body>
</html>
