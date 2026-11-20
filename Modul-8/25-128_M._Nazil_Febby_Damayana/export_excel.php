<?php
include 'koneksi.php';
include 'cek.php';

$dari   = isset($_GET['dari']) ? $_GET['dari'] : '';
$sampai = isset($_GET['sampai']) ? $_GET['sampai'] : '';

if (($dari != '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $dari)) ||
    ($sampai != '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $sampai)) ||
    ($dari != '' && $sampai != '' && $dari > $sampai)) {
    die('Rentang tanggal tidak valid.');
}

$where = 'WHERE 1=1';
if ($dari != '')   $where .= " AND waktu_transaksi >= '" . esc($dari) . "'";
if ($sampai != '') $where .= " AND waktu_transaksi <= '" . esc($sampai) . "'";

$hasil = mysqli_query($conn, "SELECT waktu_transaksi AS tanggal, SUM(total) AS total_harian
                              FROM transaksi $where
                              GROUP BY waktu_transaksi ORDER BY tanggal ASC");

header('Content-Type: application/vnd.ms-excel; charset=utf-8');
header('Content-Disposition: attachment; filename=laporan_penjualan.xls');

echo "\xEF\xBB\xBF";
echo "<table border='1'>";
echo "<tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>";

$no = 1;
$total_pendapatan = 0;
while ($row = mysqli_fetch_assoc($hasil)) {
    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . $row['total_harian'] . "</td>";
    echo "<td>" . $row['tanggal'] . "</td>";
    echo "</tr>";
    $total_pendapatan += $row['total_harian'];
}
echo "<tr><th>Total Keseluruhan</th><th>" . $total_pendapatan . "</th><th>-</th></tr>";
echo "</table>";
exit;