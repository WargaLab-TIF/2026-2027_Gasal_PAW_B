<?php
$koneksi = mysqli_connect("localhost", "root", "", "penjualan");
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$tanggal_mulai   = $_GET['tanggal_mulai'] ?? '';
$tanggal_selesai = $_GET['tanggal_selesai'] ?? '';

if ($tanggal_mulai === '' || $tanggal_selesai === '' || $tanggal_mulai > $tanggal_selesai) {
    die("Rentang tanggal tidak valid.");
}

$stmt = mysqli_prepare($koneksi,
    "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian
     FROM transaksi
     WHERE waktu_transaksi BETWEEN ? AND ?
     GROUP BY DATE(waktu_transaksi)
     ORDER BY tgl ASC");
mysqli_stmt_bind_param($stmt, "ss", $tanggal_mulai, $tanggal_selesai);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

$nama_file = "laporan_penjualan_{$tanggal_mulai}_sd_{$tanggal_selesai}.xls";
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"$nama_file\"");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<table border="1">
    <tr>
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
    </tr>
    <?php $no = 1; $grand_total = 0; while ($row = mysqli_fetch_assoc($res)): ?>
        <?php $grand_total += $row['total_harian']; ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= (int)$row['total_harian'] ?></td>
            <td><?= htmlspecialchars($row['tgl']) ?></td>
        </tr>
    <?php endwhile; ?>
    <tr>
        <th colspan="1">Total</th>
        <th><?= (int)$grand_total ?></th>
        <th></th>
    </tr>
</table>
</body>
</html>
<?php
mysqli_stmt_close($stmt);
