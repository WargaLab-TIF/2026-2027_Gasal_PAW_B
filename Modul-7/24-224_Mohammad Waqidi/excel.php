
<?php
require_once "koneksi.php";

// Mengambil tanggal dari URL
$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

// Validasi tanggal
if (
    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $mulai) ||
    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $selesai) ||
    $mulai > $selesai
) {
    die("Tanggal laporan tidak valid.");
}

// Query rekap penjualan harian
$query = "SELECT
            DATE(waktu_transaksi) AS tgl,
            SUM(total) AS total_harian
          FROM transaksi
          WHERE waktu_transaksi >= ?
          AND waktu_transaksi < DATE_ADD(?, INTERVAL 1 DAY)
          GROUP BY DATE(waktu_transaksi)
          ORDER BY tgl ASC";

$stmt = mysqli_prepare($koneksi, $query);

mysqli_stmt_bind_param($stmt, "ss", $mulai, $selesai);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

// Nama file Excel
$filename = "laporan_penjualan_" . $mulai . "_" . $selesai . ".xls";

// Header untuk membuka file di Microsoft Excel
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

// BOM agar karakter terbaca dengan benar
echo "\xEF\xBB\xBF";

// Membuat tabel laporan
echo "No\tTanggal\tTotal Penjualan\n";

$no = 1;
$total_pendapatan = 0;

while ($row = mysqli_fetch_assoc($result)) {

    $tanggal = $row['tgl'];
    $total = $row['total_harian'];

    echo $no++ . "\t";
    echo $tanggal . "\t";
    echo $total . "\n";

    $total_pendapatan += $total;
}

// Menampilkan total pendapatan
echo "\n";
echo "\tTOTAL PENDAPATAN\t" . $total_pendapatan . "\n";

mysqli_stmt_close($stmt);
exit;
?>
