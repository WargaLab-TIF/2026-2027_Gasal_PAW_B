<?php
include 'koneksi.php';
include 'cek.php';

$dari   = isset($_GET['dari']) ? esc($_GET['dari']) : '';
$sampai = isset($_GET['sampai']) ? esc($_GET['sampai']) : '';

$where = 'WHERE 1=1';
if ($dari != '')   $where .= " AND t.waktu_transaksi >= '$dari'";
if ($sampai != '') $where .= " AND t.waktu_transaksi <= '$sampai'";

$data = mysqli_query($conn, "SELECT t.*, p.nama AS pelanggan FROM transaksi t LEFT JOIN pelanggan p ON p.id = t.pelanggan_id $where ORDER BY t.waktu_transaksi, t.id");
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
        </div>
    </div>
</form>

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
<?php include 'footer.php'; ?>
