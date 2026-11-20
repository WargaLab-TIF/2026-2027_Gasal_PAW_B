
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../koneksi.php';

$mulai = $_GET['mulai'] ?? date('Y-m-01');
$selesai = $_GET['selesai'] ?? date('Y-m-d');

$query = mysqli_query($conn, "
    SELECT
        transaksi.id,
        transaksi.waktu_transaksi,
        transaksi.keterangan,
        transaksi.total,
        pelanggan.nama AS nama_pelanggan
    FROM transaksi
    LEFT JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    WHERE DATE(transaksi.waktu_transaksi) BETWEEN '$mulai' AND '$selesai'
    ORDER BY transaksi.waktu_transaksi DESC
");

if (!$query) {
    die("Query gagal: " . mysqli_error($conn));
}

$jumlah_transaksi = mysqli_num_rows($query);

$hasil_total = mysqli_query($conn, "
    SELECT SUM(total) AS total_penjualan
    FROM transaksi
    WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'
");

$total = mysqli_fetch_assoc($hasil_total);

// Data grafik
$grafik = mysqli_query($conn, "
    SELECT DATE(waktu_transaksi) AS tanggal,
           SUM(total) AS pendapatan
    FROM transaksi
    WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'
    GROUP BY DATE(waktu_transaksi)
    ORDER BY tanggal ASC
");

$labels = [];
$pendapatan = [];

while ($row = mysqli_fetch_assoc($grafik)) {
    $labels[] = $row['tanggal'];
    $pendapatan[] = (float) $row['pendapatan'];
}

include '../navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Laporan Penjualan</h4>
        </div>

        <div class="card-body">

            <form method="GET" action="index.php" class="row mb-4">
                <div class="col-md-4">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date" name="mulai" class="form-control"
                           value="<?= htmlspecialchars($mulai); ?>" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tanggal Selesai</label>
                    <input type="date" name="selesai" class="form-control"
                           value="<?= htmlspecialchars($selesai); ?>" required>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">
                        Tampilkan
                    </button>
                </div>
            </form>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="alert alert-info">
                        Jumlah Transaksi:
                        <strong><?= $jumlah_transaksi; ?></strong>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="alert alert-success">
                        Total Penjualan:
                        <strong>
                            Rp <?= number_format($total['total_penjualan'] ?? 0, 0, ',', '.'); ?>
                        </strong>
                    </div>
                </div>
            </div>

            <a href="export_excel.php?mulai=<?= urlencode($mulai); ?>&selesai=<?= urlencode($selesai); ?>"
               class="btn btn-success mb-4">
                Export Excel
            </a>

            <!-- Grafik Penjualan -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="mb-3">Grafik Penjualan</h5>
                    <canvas id="grafikPenjualan"></canvas>
                </div>
            </div>

            <!-- Tabel Laporan -->
            <h5 class="mb-3">Data Transaksi</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>ID Transaksi</th>
                            <th>Waktu Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Keterangan</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;

                        while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['id']; ?></td>
                                <td><?= htmlspecialchars($row['waktu_transaksi']); ?></td>
                                <td><?= htmlspecialchars($row['nama_pelanggan'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['keterangan'] ?? '-'); ?></td>
                                <td>Rp <?= number_format($row['total'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php } ?>

                        <?php if ($jumlah_transaksi == 0) { ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('grafikPenjualan');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels); ?>,
        datasets: [{
            label: 'Total Pendapatan',
            data: <?= json_encode($pendapatan); ?>,
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

</body>
</html>
