<?php
include 'koneksi.php';

$labels = [];
$data_total = [];
$rekap = [];

$total_pendapatan = 0;
$total_pelanggan = 0;

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

if ($mulai != '' && $selesai != '' && $mulai <= $selesai) {

    $q = mysqli_query($conn, "
        SELECT
            DATE(waktu_transaksi) AS tgl,
            SUM(total) AS total_harian
        FROM transaksi
        WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'
        GROUP BY DATE(waktu_transaksi)
        ORDER BY tgl ASC
    ");

    while ($r = mysqli_fetch_assoc($q)) {
        $labels[] = $r['tgl'];
        $data_total[] = $r['total_harian'];
        $rekap[] = $r;
        $total_pendapatan += $r['total_harian'];
    }

    $qp = mysqli_query($conn, "
        SELECT COUNT(DISTINCT pelanggan_id) AS jml
        FROM transaksi
        WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'
    ");

    $rp = mysqli_fetch_assoc($qp);
    $total_pelanggan = $rp['jml'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: Arial;
        }

        .laporan {
            margin: 20px;
        }

        .report-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .report-table th {
            background-color: #ddd;
        }

        .ringkasan {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            border: 1px solid #ccc;
            padding: 15px;
            flex: 1;
        }

        .grafik {
            width: 600px;
            max-width: 100%;
            height: 300px;
        }

        .btn {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 9px 18px;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background-color: #0b5ed7;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .grafik {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="laporan">

    <h1>Laporan Penjualan</h1>

    <div class="no-print">

        <form method="GET">
            Dari:
            <input type="date" name="mulai"
                value="<?php echo htmlspecialchars($mulai); ?>" required>

            Sampai:
            <input type="date" name="selesai"
                value="<?php echo htmlspecialchars($selesai); ?>" required>

            <button type="submit" class="btn">Tampilkan</button>
        </form>

        <?php if ($mulai != '' && $selesai != '' && $mulai <= $selesai) { ?>

            <button class="btn" onclick="window.print()">Cetak</button>

            <a class="btn"
                href="export_excel.php?mulai=<?php echo urlencode($mulai); ?>&selesai=<?php echo urlencode($selesai); ?>">
                Excel
            </a>

        <?php } ?>

        <br><br>
        <a href="transaksi.php">Kembali ke Transaksi</a>

    </div>

    <?php if ($mulai != '' && $selesai != '') { ?>

        <?php if ($mulai > $selesai) { ?>

            <p>Tanggal mulai tidak boleh melebihi tanggal selesai.</p>

        <?php } elseif (!empty($labels)) { ?>

            <h2>Grafik Penjualan Harian</h2>

            <div class="grafik">
                <canvas id="myChart"></canvas>
            </div>

            <h2>Rekapitulasi Penjualan</h2>

            <table class="report-table">
                <tr>
                    <th>No</th>
                    <th>Total Pendapatan</th>
                    <th>Tanggal Transaksi</th>
                </tr>

                <?php
                $no = 1;
                foreach ($rekap as $row) {
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td>
                        Rp <?php echo number_format(
                            $row['total_harian'], 0, ',', '.'
                        ); ?>
                    </td>
                    <td><?php echo $row['tgl']; ?></td>
                </tr>
                <?php } ?>
            </table>

            <div class="ringkasan">

                <div class="card">
                    <h3>Jumlah Pelanggan Unik</h3>
                    <h2><?php echo $total_pelanggan; ?> Orang</h2>
                </div>

                <div class="card">
                    <h3>Total Pendapatan</h3>
                    <h2>
                        Rp <?php echo number_format(
                            $total_pendapatan, 0, ',', '.'
                        ); ?>
                    </h2>
                </div>

            </div>

            <script>
                const ctx = document.getElementById('myChart');

                new Chart(ctx, {
                    type: 'bar',

                    data: {
                        labels: <?php echo json_encode($labels); ?>,

                        datasets: [{
                            label: 'Total Pendapatan',
                            data: <?php echo json_encode($data_total); ?>,
                            backgroundColor: 'rgba(180, 180, 180, 0.6)',
                            borderColor: 'rgb(150, 150, 150)',
                            borderWidth: 1
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Total Pendapatan (Rp)'
                                }
                            },

                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal Transaksi'
                                }
                            }
                        }
                    }
                });
            </script>

        <?php } else { ?>

            <p>Tidak ada data penjualan pada rentang tanggal tersebut.</p>

        <?php } ?>

    <?php } ?>

</div>

</body>
</html>