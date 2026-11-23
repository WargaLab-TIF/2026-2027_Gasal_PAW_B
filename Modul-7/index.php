<?php
include 'koneksi.php';

$data = mysqli_query($conn, "
    SELECT transaksi.*, pelanggan.nama
    FROM transaksi
    LEFT JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    ORDER BY transaksi.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Penjualan Cemilan</title>

<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 30px;
        padding: 20px;
        background-color: #fff5f8;
        color: #444;
        line-height: 1.6;
    }

    h2, h3 {
        color: #d63384;
        margin-bottom: 15px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(214, 51, 132, 0.10);
    }

    th, td {
        border: 1px solid #f5d5e3;
        padding: 12px;
        color: #444;
        text-align: left;
    }

    th {
        background-color: #e879a9;
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #fff0f5;
    }

    tr:hover {
        background-color: #fce0eb;
        transition: 0.2s;
    }

    input, select {
        padding: 9px 12px;
        margin: 5px;
        border: 1px solid #edb5cd;
        border-radius: 6px;
        color: #444;
        background-color: white;
        outline: none;
        transition: 0.2s;
    }

    input:focus, select:focus {
        border-color: #e879a9;
        box-shadow: 0 0 5px rgba(232, 121, 169, 0.3);
    }

    button {
        padding: 9px 16px;
        background-color: #e879a9;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.2s;
    }

    button:hover {
        background-color: #d63384;
        transform: translateY(-1px);
    }

    a {
        color: #d63384;
        text-decoration: none;
        transition: 0.2s;
    }

    a:hover {
        color: #ad2165;
        text-decoration: underline;
    }
</style>

</head>
<body>

<div class="container mt-4">

    <h2>Penjualan Cemilan</h2>
    <p>Aplikasi Transaksi Penjualan Cemilan</p>

    <a href="barang.php">Data Barang</a>

    <table class="table table-bordered">
        <tr class="table-dark">
            <th>No</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Keterangan</th>
            <th>Total</th>
            <th>Detail</th>
        </tr>

        <?php
        $no = 1;
        while ($t = mysqli_fetch_assoc($data)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $t['waktu_transaksi'] ?></td>
            <td><?= htmlspecialchars($t['nama'] ?? '-') ?></td>
            <td><?= htmlspecialchars($t['keterangan'] ?? '-') ?></td>
            <td>Rp <?= number_format($t['total'],0,',','.') ?></td>

            <td>
                <a href="detail.php?id=<?= $t['id'] ?>"
                   class="btn btn-info btn-sm">Detail</a>
            </td>
        </tr>
        <?php } ?>

    </table>

    <h2>Laporan Penjualan dan Grafik</h2>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>

    <div class="no-print">
        <h1>Filter Laporan Penjualan</h1>

        <form method="GET">
            Dari:
            <input type="date" name="mulai"
                value="<?= $_GET['mulai'] ?? '' ?>" required>

            Sampai:
            <input type="date" name="selesai"
                value="<?= $_GET['selesai'] ?? '' ?>" required>

            <button type="submit">Tampilkan</button>
        </form>

        <button onclick="window.print()">Cetak</button>

        <a href="export_excel.php?mulai=<?= $_GET['mulai'] ?? '' ?>&selesai=<?= $_GET['selesai'] ?? '' ?>">
            <button>Excel</button>
        </a>
    </div>

    <?php
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
              WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai'
              GROUP BY DATE(waktu_transaksi)
              ORDER BY tgl ASC";

        $res = mysqli_query($conn, $q);

        while ($r = mysqli_fetch_assoc($res)) {
            $labels[] = $r['tgl'];
            $data_total[] = $r['total_harian'];
            $rekap[] = $r;

            $total_pendapatan += $r['total_harian'];
        }

        // Query jumlah pelanggan unik
        $qp = "SELECT COUNT(DISTINCT pelanggan_id) AS jml
               FROM transaksi
               WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai'";

        $rp = mysqli_fetch_assoc(mysqli_query($conn, $qp));

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
            Rp. <?= number_format(
                $total_pendapatan,
                0,
                ',',
                '.'
            ); ?>
        </p>
    <?php endif; ?>
</div>
</body>
</html>
