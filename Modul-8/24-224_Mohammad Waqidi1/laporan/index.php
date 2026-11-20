<?php
require_once "../midlewire.php";
cek_login("../");
require_once "../koneksi.php";

$judul = "Laporan Penjualan";
include "../header.php";

$dari   = $_GET['dari'] ?? '';
$sampai = $_GET['sampai'] ?? '';

if ($dari !== '' && $sampai !== '') {
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT t.*, p.nama AS pelanggan FROM transaksi t LEFT JOIN pelanggan p ON p.id = t.pelanggan_id WHERE t.waktu_transaksi BETWEEN ? AND ? ORDER BY t.waktu_transaksi ASC, t.id ASC"
    );
    mysqli_stmt_bind_param($stmt, "ss", $dari, $sampai);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
} else {
    $res = mysqli_query(
        $koneksi,
        "SELECT t.*, p.nama AS pelanggan FROM transaksi t LEFT JOIN pelanggan p ON p.id = t.pelanggan_id ORDER BY t.waktu_transaksi DESC, t.id DESC"
    );
}

$rows = [];
$total_pendapatan = 0;
$pelanggan_unik = [];
while ($row = mysqli_fetch_assoc($res)) {
    $rows[] = $row;
    $total_pendapatan += (int)$row['total'];
    if (!empty($row['pelanggan_id'])) {
        $pelanggan_unik[$row['pelanggan_id']] = true;
    }
}
?>

<h2>Laporan Penjualan</h2>

<form method="get" class="grid no-print">
    <div>
        <label>Dari Tanggal</label>
        <input type="date" name="dari" value="<?= htmlspecialchars($dari) ?>">
    </div>
    <div>
        <label>Sampai Tanggal</label>
        <input type="date" name="sampai" value="<?= htmlspecialchars($sampai) ?>">
    </div>
    <div style="grid-column: 1 / -1">
        <button class="btn" type="submit">Tampilkan</button>
        <a class="btn danger" href="index.php">Reset</a>
        <button class="btn" type="button" onclick="window.print()">Cetak</button>
    </div>
</form>

<div class="summary-grid">
    <div class="card">
        <h3>Jumlah Transaksi</h3>
        <p><?= count($rows) ?></p>
    </div>
    <div class="card">
        <h3>Jumlah Pelanggan</h3>
        <p><?= count($pelanggan_unik) ?></p>
    </div>
    <div class="card">
        <h3>Total Pendapatan</h3>
        <p>Rp <?= number_format($total_pendapatan) ?></p>
    </div>
</div>

<table>
    <tr>
        <th>No</th>
        <th>Tanggal</th>
        <th>Pelanggan</th>
        <th>Keterangan</th>
        <th>Total</th>
    </tr>
    <?php if (empty($rows)) { ?>
        <tr>
            <td colspan="5" style="text-align: center;">Tidak ada data transaksi.</td>
        </tr>
    <?php } else { ?>
        <?php $no = 1; foreach ($rows as $r) { ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($r['waktu_transaksi']) ?></td>
                <td><?= htmlspecialchars($r['pelanggan'] ?? '-') ?></td>
                <td><?= htmlspecialchars($r['keterangan'] ?? '-') ?></td>
                <td>Rp <?= number_format($r['total']) ?></td>
            </tr>
        <?php } ?>
    <?php } ?>
</table>

<?php include "../footer.php"; ?>
