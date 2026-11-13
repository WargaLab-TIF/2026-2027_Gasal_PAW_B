
<?php
include 'koneksi.php';

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

if ($mulai == '' || $selesai == '') {
    die("Tanggal belum dipilih.");
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan.xls");

$query = mysqli_query($koneksi, "
    SELECT
        DATE(waktu_transaksi) AS tgl,
        SUM(total) AS total_harian
    FROM transaksi
    WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'
    GROUP BY DATE(waktu_transaksi)
    ORDER BY tgl ASC
");

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<h2>Laporan Penjualan</h2>

<p>Periode: <?php echo $mulai; ?> sampai <?php echo $selesai; ?></p>

<table border="1">
    <tr>
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
    </tr>

    <?php
    $no = 1;
    $total = 0;

    while ($row = mysqli_fetch_assoc($query)) {
        $total += $row['total_harian'];
    ?>

        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['total_harian']; ?></td>
            <td><?php echo $row['tgl']; ?></td>
        </tr>

    <?php } ?>

    <tr>
        <th>Total Keseluruhan</th>
        <th colspan="2"><?php echo $total; ?></th>
    </tr>
</table>
