
<?php
require_once "koneksi.php";

$mulai = $_GET['mulai'];
$selesai = $_GET['selesai'];

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");

$query = "SELECT DATE(waktu_transaksi) AS tgl,
          SUM(total) AS total_harian
          FROM transaksi
          WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'
          GROUP BY DATE(waktu_transaksi)
          ORDER BY tgl ASC";

$result = mysqli_query($koneksi, $query);

echo "No\tTanggal\tTotal Penjualan\n";

$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    echo $no++ . "\t";
    echo $row['tgl'] . "\t";
    echo $row['total_harian'] . "\n";
}
?>
