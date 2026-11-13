<?php
include 'koneksi.php';

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

if ($mulai == '' || $selesai == '') {
    die("Tanggal belum dipilih.");
}

if ($mulai > $selesai) {
    die("Rentang tanggal tidak valid.");
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Penjualan.xls");

$query = mysqli_query($conn, "
    SELECT
        DATE(waktu_transaksi) AS tanggal,
        SUM(total) AS total_pendapatan
    FROM transaksi
    WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'
    GROUP BY DATE(waktu_transaksi)
    ORDER BY tanggal ASC
");

$total = 0;
?>

<h2>REKAP LAPORAN PENJUALAN</h2>

<p>
    Periode: <?php echo $mulai; ?>
    sampai <?php echo $selesai; ?>
</p>

<table border="1">
    <tr>
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
    </tr>

    <?php
    $no = 1;

    while ($row = mysqli_fetch_assoc($query)) {
        $total += $row['total_pendapatan'];
    ?>

    <tr>
        <td><?php echo $no++; ?></td>

        <td>
            Rp <?php echo number_format(
                $row['total_pendapatan'], 0, ',', '.'
            ); ?>
        </td>

        <td><?php echo $row['tanggal']; ?></td>
    </tr>

    <?php } ?>

    <tr>
        <th colspan="1">Total Keseluruhan</th>
        <th colspan="2">
            Rp <?php echo number_format($total, 0, ',', '.'); ?>
        </th>
    </tr>
</table>