<?php
include 'koneksi.php';
include 'cek.php';

$dari   = isset($_GET['dari']) ? esc($_GET['dari']) : '';
$sampai = isset($_GET['sampai']) ? esc($_GET['sampai']) : '';

$where = 'WHERE 1=1';
if ($dari != '')   $where .= " AND t.waktu_transaksi >= '$dari'";
if ($sampai != '') $where .= " AND t.waktu_transaksi <= '$sampai'";

$data = mysqli_query($conn, "SELECT t.*, p.nama AS pelanggan FROM transaksi t LEFT JOIN pelanggan p ON p.id = t.pelanggan_id $where ORDER BY t.waktu_transaksi, t.id");

$labels = [];
$data_total = [];
$grafik = mysqli_query($conn, "SELECT t.waktu_transaksi AS tanggal, SUM(t.total) AS total_harian FROM transaksi t $where GROUP BY t.waktu_transaksi ORDER BY t.waktu_transaksi");
while ($g = mysqli_fetch_assoc($grafik)) {
    $labels[] = $g['tanggal'];
    $data_total[] = (int) $g['total_harian'];
}

include 'header.php';
?>
<h4>Laporan Penjualan</h4>

<form method="get" class="card card-body mb-4">
    <div class="row g-2">
        <div class="col-md-4"><input type="date" name="dari" class="form-control" value="<?= h($dari) ?>"></div>
        <div class="col-md-4"><input type="date" name="sampai" class="form-control" value="<?= h($sampai) ?>"></div>
        <div class="col-md-4">
            <button class="btn btn-primary">Tampilkan</button>
            <a href="laporan.php" class="btn btn-secondary">Reset</a>
            <button type="button" class="btn btn-outline-dark" onclick="window.print()">Cetak</button>
            <a href="export_excel.php?dari=<?= urlencode($dari) ?>&sampai=<?= urlencode($sampai) ?>" class="btn btn-success">Export Excel</a>
        </div>
    </div>
</form>

<div class="card card-body mb-4">
    <h5>Grafik Penjualan</h5>
    <canvas id="grafik" height="100"></canvas>
</div>

<table class="table table-bordered table-striped">
    <tr><th>No</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total</th></tr>
    <?php
    $no = 1; $jumlah = 0;
    while ($d = mysqli_fetch_assoc($data)) {
        $jumlah += $d['total'];
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $d['waktu_transaksi'] ?></td>
        <td><?= h($d['pelanggan']) ?></td>
        <td><?= h($d['keterangan']) ?></td>
        <td><?= rp($d['total']) ?></td>
    </tr>
    <?php } ?>
    <tr><th colspan="4" class="text-end">Total Penjualan</th><th><?= rp($jumlah) ?></th></tr>
</table>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('grafik'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Total Penjualan',
            data: <?= json_encode($data_total) ?>
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});
</script>
<?php include 'footer.php'; ?>
