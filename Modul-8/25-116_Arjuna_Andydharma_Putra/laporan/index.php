<?php
include '../koneksi.php';
cek_login(); // semua level boleh akses laporan

// ringkasan sederhana
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM transaksi"))['jml'];
$total_penjualan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total),0) as jml FROM transaksi"))['jml'];
$total_barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM barang"))['jml'];
$total_pelanggan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as jml FROM pelanggan"))['jml'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f6fa; }
        .container { padding: 20px 30px; }
        h2 { color: #2c3e50; }
        .card-box {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .card {
            background: white;
            padding: 20px 25px;
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
            min-width: 180px;
        }
        .card h3 { margin: 0 0 8px; font-size: 14px; color: #777; }
        .card .angka { font-size: 24px; font-weight: bold; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 30px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; }
        th { background: #2c3e50; color: white; }
    </style>
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="container">
        <h2>Laporan Ringkas</h2>
        <p style="color:#666; font-size:14px;">Laporan sesuai modul sebelumnya (versi sederhana).</p>

        <div class="card-box">
            <div class="card">
                <h3>Total Transaksi</h3>
                <div class="angka"><?= $total_transaksi ?></div>
            </div>
            <div class="card">
                <h3>Total Penjualan</h3>
                <div class="angka">Rp <?= number_format($total_penjualan, 0, ',', '.') ?></div>
            </div>
            <div class="card">
                <h3>Jumlah Barang</h3>
                <div class="angka"><?= $total_barang ?></div>
            </div>
            <div class="card">
                <h3>Jumlah Pelanggan</h3>
                <div class="angka"><?= $total_pelanggan ?></div>
            </div>
        </div>

        <h3 style="margin-top:40px;">Transaksi Terakhir</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Total</th>
            </tr>
            <?php
            $q = mysqli_query($conn, "SELECT t.*, p.nama AS nama_pelanggan 
                                      FROM transaksi t 
                                      LEFT JOIN pelanggan p ON t.pelanggan_id = p.id 
                                      ORDER BY t.id DESC LIMIT 10");
            while ($row = mysqli_fetch_assoc($q)) {
            ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['waktu_transaksi'] ?></td>
                <td><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
                <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
