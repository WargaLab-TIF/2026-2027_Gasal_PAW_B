<?php
include '../koneksi.php';
cek_login(); // semua level boleh akses transaksi

$hasil = mysqli_query($conn, "SELECT t.*, p.nama AS nama_pelanggan 
                              FROM transaksi t 
                              LEFT JOIN pelanggan p ON t.pelanggan_id = p.id 
                              ORDER BY t.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #f5f6fa; }
        .container { padding: 20px 30px; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; font-size: 14px; }
        th { background: #2c3e50; color: white; }
        tr:nth-child(even) { background: #f9f9f9; }
        h2 { color: #2c3e50; }
        .btn { padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; color: white; background: #3498db; }
    </style>
</head>
<body>
    <?php include '../navbar.php'; ?>
    <div class="container">
        <h2>Data Transaksi</h2>
        <p style="color:#666; font-size:14px;">Halaman transaksi (sesuai modul sebelumnya). Untuk demo, menampilkan data yang sudah ada.</p>
        <table>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Keterangan</th>
                <th>Total</th>
            </tr>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($hasil)) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['id'] ?></td>
                <td><?= $row['waktu_transaksi'] ?></td>
                <td><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                <td>Rp <?= number_format($row['total'], 0, ',', '.') ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
