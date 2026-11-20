<?php
include 'auth.php';
wajibLogin();
include 'koneksi.php';

$awal = $_GET['tanggal_mulai'] ?? date('Y-m-01');
$akhir = $_GET['tanggal_selesai'] ?? date('Y-m-d');

if (
    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $awal) ||
    !preg_match('/^\d{4}-\d{2}-\d{2}$/', $akhir) ||
    $awal > $akhir ||
    !checkdate((int)substr($awal,5,2), (int)substr($awal,8,2), (int)substr($awal,0,4)) ||
    !checkdate((int)substr($akhir,5,2), (int)substr($akhir,8,2), (int)substr($akhir,0,4))
) {
    die("Tanggal tidak valid!");
}

$stmt = mysqli_prepare($conn,
    "SELECT DATE(waktu_transaksi) tanggal, SUM(total) pendapatan
     FROM transaksi
     WHERE DATE(waktu_transaksi) BETWEEN ? AND ?
     GROUP BY DATE(waktu_transaksi)
     ORDER BY tanggal"
);

mysqli_stmt_bind_param($stmt, "ss", $awal, $akhir);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$tanggal = [];
$pendapatan = [];

while ($row = mysqli_fetch_assoc($result)) {
    $tanggal[] = date('d-m-Y', strtotime($row['tanggal']));
    $pendapatan[] = (int)$row['pendapatan'];
}

$stmt = mysqli_prepare($conn,
    "SELECT COALESCE(SUM(total),0) pendapatan,
            COUNT(*) transaksi,
            COUNT(DISTINCT pelanggan_id) pelanggan
     FROM transaksi
     WHERE DATE(waktu_transaksi) BETWEEN ? AND ?"
);

mysqli_stmt_bind_param($stmt, "ss", $awal, $akhir);
mysqli_stmt_execute($stmt);
$ringkasan = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$stmt = mysqli_prepare($conn,
    "SELECT transaksi.id, transaksi.waktu_transaksi,
            pelanggan.nama, transaksi.total
     FROM transaksi
     LEFT JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
     WHERE DATE(transaksi.waktu_transaksi) BETWEEN ? AND ?
     ORDER BY transaksi.waktu_transaksi DESC"
);

mysqli_stmt_bind_param($stmt, "ss", $awal, $akhir);
mysqli_stmt_execute($stmt);
$data = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan Penjualan</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
body {
    font-family: Arial;
    background: #f4f6f9;
    padding: 20px;
}
.container {
    max-width: 1000px;
    margin: auto;
}
.card {
    background: white;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
}
.summary {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}
.summary .card {
    flex: 1;
    min-width: 180px;
}
input, button {
    padding: 9px;
    margin: 5px;
}
button {
    background: #2878d0;
    color: white;
    border: none;
    cursor: pointer;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}
th {
    background: #2878d0;
    color: white;
}
.chart {
    height: 300px;
}
@media print {
    .no-print {
        display: none;
    }
    body {
        background: white;
    }
}
</style>
</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container">

<h2>Laporan Penjualan</h2>

<div class="card no-print">
    <form method="GET">
        Tanggal Mulai
        <input type="date" name="tanggal_mulai"
            value="<?= htmlspecialchars($awal) ?>" required>

        Tanggal Selesai
        <input type="date" name="tanggal_selesai"
            value="<?= htmlspecialchars($akhir) ?>" required>

        <button type="submit">Tampilkan</button>
    </form>
</div>

<div class="summary">

    <div class="card">
        <h4>Total Transaksi</h4>
        <h2><?= $ringkasan['transaksi'] ?></h2>
    </div>

    <div class="card">
        <h4>Total Pelanggan</h4>
        <h2><?= $ringkasan['pelanggan'] ?></h2>
    </div>

    <div class="card">
        <h4>Total Pendapatan</h4>
        <h2>Rp <?= number_format($ringkasan['pendapatan'],0,',','.') ?></h2>
    </div>

</div>

<div class="card">
    <h3>Grafik Pendapatan Harian</h3>

    <div class="chart">
        <canvas id="grafik"></canvas>
    </div>
</div>

<div class="card">

    <h3>Rekapitulasi Penjualan</h3>

    <p>
        Periode:
        <?= date('d-m-Y',strtotime($awal)) ?>
        sampai
        <?= date('d-m-Y',strtotime($akhir)) ?>
    </p>

    <button class="no-print" onclick="window.print()">
        Cetak
    </button>

    <table>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>ID Transaksi</th>
            <th>Pelanggan</th>
            <th>Total Penjualan</th>
        </tr>

        <?php $no = 1; ?>

        <?php while ($row = mysqli_fetch_assoc($data)) { ?>

        <tr>
            <td><?= $no++ ?></td>

            <td>
                <?= date('d-m-Y',strtotime($row['waktu_transaksi'])) ?>
            </td>

            <td><?= $row['id'] ?></td>

            <td><?= htmlspecialchars($row['nama'] ?? '-') ?></td>

            <td>
                Rp <?= number_format($row['total'],0,',','.') ?>
            </td>
        </tr>

        <?php } ?>

        <?php if ($no == 1) { ?>
        <tr>
            <td colspan="5">Belum ada transaksi</td>
        </tr>
        <?php } ?>

    </table>

</div>

</div>

<script>
new Chart(document.getElementById('grafik'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($tanggal) ?>,
        datasets: [{
            label: 'Pendapatan',
            data: <?= json_encode($pendapatan) ?>,
            backgroundColor: '#2878d0'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => 'Rp ' + value.toLocaleString('id-ID')
                }
            }
        }
    }
});
</script>

</body>
</html>