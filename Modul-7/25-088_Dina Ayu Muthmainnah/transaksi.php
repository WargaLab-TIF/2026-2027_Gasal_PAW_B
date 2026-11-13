<?php
include 'koneksi.php';

$query = mysqli_query($conn, "
    SELECT transaksi.*, pelanggan.nama
    FROM transaksi
    JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    ORDER BY transaksi.id
");

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
    <title>Data Transaksi dan Laporan Penjualan</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* CSS khusus bagian laporan */
        .laporan {
            font-family: Arial;
            margin-top: 40px;
        }

        .laporan .report-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }

        .laporan .report-table th,
        .laporan .report-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .laporan .report-table th {
            background-color: #ddd;
        }

        .laporan .ringkasan {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .laporan .card {
            border: 1px solid #ccc;
            padding: 15px;
            flex: 1;
        }

        .laporan .grafik {
            width: 600px;
            max-width: 100%;
            height: 300px;
        }

        .laporan button {
            padding: 8px 15px;
            margin: 5px;
            cursor: pointer;
        }

        @media print {
            .no-print,
            .data-transaksi,
            .detail-transaksi {
                display: none !important;
            }

            .laporan .grafik {
                width: 100%;
            }
        }
    </style>

</head>

<body>

<div class="data-transaksi">

    <h2>Data Transaksi</h2>

    <table border="1" cellpadding="10">

        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Keterangan</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($query)) { ?>

            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['waktu_transaksi']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['keterangan']; ?></td>
                <td><?php echo $row['total']; ?></td>

                <td>
                    <a href="transaksi.php?id=<?php echo $row['id']; ?>">
                        Detail
                    </a>
                </td>
            </tr>

        <?php } ?>

    </table>

</div>

<?php
if (isset($_GET['id'])) {

    $id = (int) $_GET['id'];

    $detail = mysqli_query($conn, "
        SELECT transaksi_detail.*, barang.nama_barang
        FROM transaksi_detail
        JOIN barang ON transaksi_detail.barang_id = barang.id
        WHERE transaksi_detail.transaksi_id = $id
    ");
?>

<div class="detail-transaksi">

    <h2>Detail Transaksi Nomor <?php echo $id; ?></h2>

    <a href="tambah_detail.php?id=<?php echo $id; ?>">
        Tambah Barang
    </a>

    <br><br>

    <table border="1" cellpadding="10">

        <tr>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>

        <?php while ($d = mysqli_fetch_assoc($detail)) { ?>

            <tr>
                <td><?php echo $d['nama_barang']; ?></td>
                <td><?php echo $d['harga']; ?></td>
                <td><?php echo $d['qty']; ?></td>
                <td><?php echo $d['harga'] * $d['qty']; ?></td>
            </tr>

        <?php } ?>

    </table>

</div>

<?php } ?>

<br>

<div class="no-print">
    <a href="barang.php">Kelola Barang</a>
</div>

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

            <button type="submit">Tampilkan</button>

        </form>

        <?php if ($mulai != '' && $selesai != '' && $mulai <= $selesai) { ?>

            <button onclick="window.print()">Cetak</button>

            <a href="export_excel.php?mulai=<?php echo urlencode($mulai); ?>&selesai=<?php echo urlencode($selesai); ?>">
                <button type="button">Excel</button>
            </a>

        <?php } ?>

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
                                $row['total_harian'],
                                0,
                                ',',
                                '.'
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
                            $total_pendapatan,
                            0,
                            ',',
                            '.'
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