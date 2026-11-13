<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Penjualan.xls");

$koneksi = mysqli_connect("localhost", "root", "", "penjualan");

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

$q = "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian 
      FROM transaksi 
      WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai' 
      GROUP BY DATE(waktu_transaksi) 
      ORDER BY tgl ASC";
$res = mysqli_query($koneksi, $q);

$total_pendapatan = 0;
$rekap = [];

while ($row = mysqli_fetch_assoc($res)) {
    $rekap[] = $row;
    $total_pendapatan += $row['total_harian'];
}

$qp = "SELECT COUNT(DISTINCT pelanggan_id) AS jml 
       FROM transaksi 
       WHERE DATE(waktu_transaksi) BETWEEN '$mulai' AND '$selesai'";
$res_pelanggan = mysqli_query($koneksi, $qp);
$data_pelanggan = mysqli_fetch_assoc($res_pelanggan);
$total_pelanggan = $data_pelanggan['jml'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
</head>
<body>

    <center>
        <h2>REKAP LAPORAN PENJUALAN</h2>
        <p>Periode: <?= $mulai; ?> sampai <?= $selesai; ?></p>
    </center>

    <table border="1" cellpadding="5" cellspacing="0" width="100%">
        <tr>
            <th>No</th>
            <th>Total Pendapatan</th>
            <th>Tanggal Transaksi</th>
        </tr>
        <?php 
        $no = 1; 
        foreach ($rekap as $row): 
        ?>
        <tr>
            <td align="center"><?= $no++; ?></td>
            <td>Rp. <?= number_format($row['total_harian'], 0, ',', '.'); ?></td>
            <td align="center"><?= $row['tgl']; ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <th colspan="2" align="right">Jumlah Pelanggan Unik:</th>
            <th align="center"><?= $total_pelanggan; ?> Orang</th>
        </tr>
        <tr>
            <th colspan="2" align="right">Total Pendapatan Keseluruhan:</th>
            <th align="left">Rp. <?= number_format($total_pendapatan, 0, ',', '.'); ?></th>
        </tr>
    </table>

</body>
</html>
