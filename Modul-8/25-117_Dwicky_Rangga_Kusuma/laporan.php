<?php
require_once "auth.php";
wajib_login();

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

$rekap = [];
$labels = [];
$data_total = [];
$total_pendapatan = 0;
$total_pelanggan = 0;
$error = "";

function tanggal_valid($tanggal) {
    $date = DateTime::createFromFormat('!Y-m-d', $tanggal);
    return $date && $date->format('Y-m-d') === $tanggal;
}

$filter_valid = false;

if ($mulai != '' && $selesai != '') {
    if (!tanggal_valid($mulai) || !tanggal_valid($selesai)) {
        $error = "Format tanggal tidak valid.";
    } elseif ($mulai > $selesai) {
        $error = "Tanggal mulai tidak boleh melebihi tanggal selesai.";
    } else {
        $filter_valid = true;
    }
}

if ($filter_valid) {
    $sql = "SELECT DATE(waktu_transaksi) AS tgl,
            SUM(total) AS total_harian
            FROM transaksi
            WHERE waktu_transaksi BETWEEN ? AND ?
            GROUP BY DATE(waktu_transaksi)
            ORDER BY tgl ASC";

    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $mulai, $selesai);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $rekap[] = $row;
        $labels[] = $row['tgl'];
        $data_total[] = (int)$row['total_harian'];

        $total_pendapatan += (int)$row['total_harian'];
    }

    $sql_pelanggan = "SELECT COUNT(DISTINCT pelanggan_id) AS jumlah
                      FROM transaksi
                      WHERE waktu_transaksi BETWEEN ? AND ?";

    $stmt_pelanggan = mysqli_prepare($koneksi, $sql_pelanggan);

    mysqli_stmt_bind_param($stmt_pelanggan, "ss", $mulai, $selesai);
    mysqli_stmt_execute($stmt_pelanggan);

    $result_pelanggan = mysqli_stmt_get_result($stmt_pelanggan);
    $data_pelanggan = mysqli_fetch_assoc($result_pelanggan);
    $total_pelanggan = (int)$data_pelanggan['jumlah'];
}
awal_halaman("Laporan Penjualan", "Laporan");
?>

<h3>Filter Laporan Penjualan</h3>
<form method="GET" action="laporan.php">
    <label>Dari:</label>
    <input type="date" name="mulai" value="<?= e($mulai) ?>" required>
    <label>Sampai:</label>
    <input type="date" name="selesai" value="<?= e($selesai) ?>" required>
    <button type="submit">Tampilkan</button>
</form>

<?php if ($error): ?>
    <p><?= e($error) ?></p>
<?php endif; ?>
<?php if ($filter_valid): ?>

    <p>Periode: <?= e($mulai) ?> sampai <?= e($selesai) ?></p>
    <button onclick="window.print()">Cetak / PDF</button>
    <a href="export_excel.php?mulai=<?= $_GET['mulai'] ?? ''?>&selesai=<?= $_GET['selesai'] ?? '' ?>"><button>Excel</button></a>
    <h3>Ringkasan Penjualan</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Total Pendapatan</th>
            <th>Jumlah Pelanggan</th>
            <th>Jumlah Hari Transaksi</th>
        </tr>
        <tr>
            <td>Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></td>
            <td><?= $total_pelanggan ?> Orang</td>
            <td><?= count($rekap) ?> Hari</td>
        </tr>
    </table>
    <h3>Grafik Penjualan Harian</h3>
    <?php if (count($rekap) > 0): ?>
        <div style="width: 100%; max-width: 750px;">
            <canvas id="grafikPenjualan"></canvas>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const labels = <?= json_encode($labels) ?>;
            const dataTotal = <?= json_encode($data_total) ?>;
            const ctx = document.getElementById('grafikPenjualan');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,

                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: dataTotal,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgb(54, 162, 235)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        </script>

    <?php else: ?>
        <p>Tidak ada transaksi pada periode tersebut.</p>
    <?php endif; ?>

    <h3>Rekapitulasi Penjualan</h3>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
        <tr>
            <th>No</th>
            <th>Tanggal Transaksi</th>
            <th>Total Penjualan</th>
        </tr>
        <?php $no = 1; ?>
        <?php foreach ($rekap as $row): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= e($row['tgl']) ?></td>
                <td>Rp <?= number_format($row['total_harian'], 0, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="2">Total Pendapatan</th>
            <th>Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></th>
        </tr>
    </table>
<?php endif; ?>

<style>
    @media print {
        .nav,
        body > h1,
        button,
        form {
            display: none !important;
        }
        body {
            background: white;
            max-width: 100%;
            margin: 0;
        }
    }
</style>

<?php
akhir_halaman();
?>