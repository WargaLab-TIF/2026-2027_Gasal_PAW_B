<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penjualan";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$labels = []; $data_total = []; $rekap = [];
$total_pendapatan = 0; $total_pelanggan = 0;

if (!empty($_GET['mulai']) && !empty($_GET['selesai'])) {
    $mulai = $_GET['mulai'];
    $selesai = $_GET['selesai'];

    $q = "SELECT DATE(waktu_transaksi) AS tgl, SUM(total) AS total_harian
          FROM transaksi WHERE waktu_transaksi BETWEEN ? AND ?
          GROUP BY DATE(waktu_transaksi) ORDER BY tgl ASC";
    $stmt = mysqli_prepare($conn, $q);
    mysqli_stmt_bind_param($stmt, 'ss', $mulai, $selesai);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    while ($r = mysqli_fetch_assoc($res)) {
        $labels[] = $r['tgl'];
        $data_total[] = $r['total_harian'];
        $rekap[] = $r;
        $total_pendapatan += $r['total_harian'];
    }

    $qp = "SELECT COUNT(DISTINCT pelanggan_id) AS jml FROM transaksi
           WHERE waktu_transaksi BETWEEN ? AND ?";
    $stmt2 = mysqli_prepare($conn, $qp);
    mysqli_stmt_bind_param($stmt2, 'ss', $mulai, $selesai);
    mysqli_stmt_execute($stmt2);
    $rp = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt2));
    $total_pelanggan = $rp['jml'] ?? 0;
}
?>
