
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once "../../config/koneksi.php";

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

if ($mulai == '' || $selesai == '') {
    die("Tanggal belum dipilih.");
}

$tanggal_mulai = DateTime::createFromFormat('Y-m-d', $mulai);
$tanggal_selesai = DateTime::createFromFormat('Y-m-d', $selesai);

if (
    !$tanggal_mulai ||
    !$tanggal_selesai ||
    $tanggal_mulai->format('Y-m-d') != $mulai ||
    $tanggal_selesai->format('Y-m-d') != $selesai ||
    $mulai > $selesai
) {
    die("Rentang tanggal tidak valid.");
}

$query = "
    SELECT
        DATE(waktu_transaksi) AS tgl,
        SUM(total) AS total_harian
    FROM transaksi
    WHERE waktu_transaksi >= ?
    AND waktu_transaksi < DATE_ADD(?, INTERVAL 1 DAY)
    GROUP BY DATE(waktu_transaksi)
    ORDER BY tgl ASC
";

$stmt = mysqli_prepare($koneksi, $query);

mysqli_stmt_bind_param($stmt, "ss", $mulai, $selesai);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_penjualan.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<h2>Laporan Penjualan</h2>

<p>
    Periode:
    <?= htmlspecialchars($mulai); ?>
    sampai
    <?= htmlspecialchars($selesai); ?>
</p>

<table border="1">
    <tr>
        <th>No</th>
        <th>Total Pendapatan</th>
        <th>Tanggal Transaksi</th>
    </tr>

    <?php
    $no = 1;
    $total = 0;

    while ($row = mysqli_fetch_assoc($result)) {
        $total += $row['total_harian'];
    ?>

    <tr>
        <td><?= $no++; ?></td>
        <td><?= $row['total_harian']; ?></td>
        <td><?= htmlspecialchars($row['tgl']); ?></td>
    </tr>

    <?php } ?>

    <tr>
        <th colspan="1">Total Keseluruhan</th>
        <th colspan="2"><?= $total; ?></th>
    </tr>
</table>
