
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once "../../config/koneksi.php";

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

$labels = [];
$data_total = [];
$rekap = [];

$total_pendapatan = 0;
$total_pelanggan = 0;

$valid_filter = false;

if ($mulai != '' && $selesai != '') {
    $tanggal_mulai = DateTime::createFromFormat('Y-m-d', $mulai);
    $tanggal_selesai = DateTime::createFromFormat('Y-m-d', $selesai);

    if (
        $tanggal_mulai &&
        $tanggal_selesai &&
        $tanggal_mulai->format('Y-m-d') == $mulai &&
        $tanggal_selesai->format('Y-m-d') == $selesai &&
        $mulai <= $selesai
    ) {
        $valid_filter = true;

        $query = "
            SELECT
                DATE(waktu_transaksi) AS tgl,
                SUM(total) AS total_harian
            FROM transaksi
            WHERE waktu_transaksi >= ?
            AND waktu_transaksi < DATE_ADD(?, INTERVAL 1 DAY)
            GROUP BY DATE(waktu_transaksi)
            ORDER BY tgl ASC
        ";

        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "ss", $mulai, $selesai);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $labels[] = $row['tgl'];
            $data_total[] = (int) $row['total_harian'];
            $rekap[] = $row;

            $total_pendapatan += $row['total_harian'];
        }

        $query_pelanggan = "
            SELECT COUNT(DISTINCT pelanggan_id) AS jml
            FROM transaksi
            WHERE waktu_transaksi >= ?
            AND waktu_transaksi < DATE_ADD(?, INTERVAL 1 DAY)
        ";

        $stmt_pelanggan = mysqli_prepare($koneksi, $query_pelanggan);
        mysqli_stmt_bind_param($stmt_pelanggan, "ss", $mulai, $selesai);
        mysqli_stmt_execute($stmt_pelanggan);

        $result_pelanggan = mysqli_stmt_get_result($stmt_pelanggan);
        $data_pelanggan = mysqli_fetch_assoc($result_pelanggan);

        $total_pelanggan = $data_pelanggan['jml'] ?? 0;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="../../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<nav>
    <a href="../home/index.php">Home</a>

    <?php if ($_SESSION['role'] == 'owner') { ?>
    <div>
        <a href="#">Data Master</a>
        <div>
            <a href="../barang/barang.php">Data Barang</a>
            <a href="../supplier/suplier.php">Data Supplier</a>
            <a href="../pelanggan/pelanggan.php">Data Pelanggan</a>
            <a href="../user/user.php">Data User</a>
        </div>
    </div>
    <?php } ?>

    <a href="../transaksi/transaksi.php">Transaksi</a>
    <a href="laporan.php">Laporan</a>

    <div class="user-dropdown">
    <button class="user-button" type="button">
        <?= htmlspecialchars($_SESSION['nama']); ?>
        <span>▼</span>
    </button>

    <div class="user-dropdown-content">
        <a href="../../auth/logout.php">Logout</a>
    </div>
    </div>
</nav>

<div class="container">
    <h2>Laporan Penjualan</h2>

    <form method="GET">
        <label>Dari Tanggal</label>
        <input
            type="date"
            name="mulai"
            value="<?= htmlspecialchars($mulai); ?>"
            required
        >

        <label>Sampai Tanggal</label>
        <input
            type="date"
            name="selesai"
            value="<?= htmlspecialchars($selesai); ?>"
            required
        >

        <button type="submit">Tampilkan</button>
    </form>

    <?php if ($mulai != '' && $selesai != '' && !$valid_filter) { ?>
        <p class="alert alert-error">
            Rentang tanggal tidak valid.
        </p>
    <?php } ?>

    <?php if ($valid_filter) { ?>

        <?php if (!empty($labels)) { ?>

        <h3>Grafik Penjualan</h3>

        <div style="height:350px;">
            <canvas id="myChart"></canvas>
        </div>

        <h3>Rekapitulasi Penjualan</h3>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Total Penjualan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($rekap as $row) { ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>
                        Rp <?= number_format($row['total_harian'], 0, ',', '.'); ?>
                    </td>
                    <td><?= htmlspecialchars($row['tgl']); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <h3>Ringkasan Penjualan</h3>

        <p>
            <b>Jumlah Pelanggan:</b>
            <?= $total_pelanggan; ?> Orang
        </p>

        <p>
            <b>Jumlah Pendapatan:</b>
            Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?>
        </p>

        <button type="button" onclick="window.print()">Cetak</button>

        <a href="export_excel.php?mulai=<?= urlencode($mulai); ?>&selesai=<?= urlencode($selesai); ?>">
            <button type="button">Export Excel</button>
        </a>

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
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>

        <?php } else { ?>
            <p class="alert">
                Tidak ada data penjualan pada rentang tanggal tersebut.
            </p>
        <?php } ?>

    <?php } ?>
</div>

</body>
</html>
