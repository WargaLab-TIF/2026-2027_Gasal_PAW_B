<?php
require 'koneksi.php';
$tanggal_mulai = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

if (
    !$tanggal_mulai || !$tanggal_selesai ||
    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_mulai) ||
    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal_selesai) ||
    $tanggal_mulai > $tanggal_selesai
) {
    die("Rentang tanggal tidak valid.");
}

$query = "SELECT
            DATE(waktu_transaksi) AS tanggal,
            SUM(total) AS total_harian
          FROM transaksi
          WHERE DATE(waktu_transaksi) BETWEEN ? AND ?
          GROUP BY DATE(waktu_transaksi)
          ORDER BY tanggal ASC";
$stmt = mysqli_prepare($koneksi, $query);

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $tanggal_mulai,
    $tanggal_selesai
);

mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

echo "\xEF\xBB\xBF";
echo "<table border='1'>";
echo "<tr>";
echo "<th>No</th>";
echo "<th>Total Pendapatan</th>";
echo "<th>Tanggal Transaksi</th>";
echo "</tr>";

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
echo "<tr>";
echo "<th colspan='1'>Total Keseluruhan</th>";
echo "<th>" . $total_pendapatan . "</th>";
echo "<th>-</th>";
echo "</tr>";
echo "</table>";
exit;
?>