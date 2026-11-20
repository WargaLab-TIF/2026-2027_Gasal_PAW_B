
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

if (!in_array($_SESSION['level'], [1, 2])) {
    header("Location: ../index.php");
    exit;
}

require_once '../koneksi.php';

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

if ($mulai === '' || $selesai === '' || $mulai > $selesai) {
    die("Rentang tanggal tidak valid.");
}

$q = mysqli_prepare($conn, "
    SELECT
        DATE(waktu_transaksi) AS tanggal,
        SUM(total) AS total_pendapatan
    FROM transaksi
    WHERE DATE(waktu_transaksi) BETWEEN ? AND ?
    GROUP BY DATE(waktu_transaksi)
    ORDER BY tanggal ASC
");

if (!$q) {
    die("Query gagal: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($q, "ss", $mulai, $selesai);
mysqli_stmt_execute($q);

$query = mysqli_stmt_get_result($q);

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=Laporan_Penjualan.xls");

$total = 0;
?>

<h2>REKAP LAPORAN PENJUALAN</h2>

<p>
    Periode: <?= htmlspecialchars($mulai); ?>
    sampai <?= htmlspecialchars($selesai); ?>
</p>

<table border="1">
    <tr>
        <th>No</th>
        <th>Tanggal Transaksi</th>
        <th>Total Pendapatan</th>
    </tr>

    <?php
    $no = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $total += $row['total_pendapatan'];
    ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($row['tanggal']); ?></td>
            <td>Rp <?= number_format($row['total_pendapatan'], 0, ',', '.'); ?></td>
        </tr>
    <?php } ?>

    <tr>
        <th colspan="2">Total Keseluruhan</th>
        <th>Rp <?= number_format($total, 0, ',', '.'); ?></th>
    </tr>
</table>
