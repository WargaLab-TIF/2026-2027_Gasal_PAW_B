<?php
require 'koneksi.php';

$transaksi = mysqli_query($koneksi, "
    SELECT t.*, p.nama AS nama_pelanggan
    FROM transaksi t
    JOIN pelanggan p ON p.id=t.pelanggan_id
    ORDER BY t.id ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Master Detail Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 25px;
            color: #222;
        }
        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 24px;
            border-radius: 10px;
        }
        h2 {
            margin-top: 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #263b59;
            color: white;
        }
        a.btn {
            display: inline-block;
            padding: 7px 11px;
            background: #1769aa;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a.secondary {
            background: #555;
        }
        .money {
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Data Transaksi (Master)</h2>
        <p>
            Halaman ini menampilkan data transaksi sebagai master.
            Klik Detail untuk melihat barang yang ada pada transaksi.
        </p>
        <table>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Keterangan</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>

            <?php while($row=mysqli_fetch_assoc($transaksi)){ ?>

                <tr>
                    <td><?= (int)$row['id'] ?></td>
                    <td><?= htmlspecialchars($row['waktu_transaksi']) ?></td>
                    <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                    <td><?= htmlspecialchars($row['keterangan']) ?></td>
                    <td class="money">Rp <?= number_format($row['total'],0,',','.') ?></td>
                    <td><a class="btn" href="detail_transaksi.php?id=<?= (int)$row['id'] ?>">Lihat Detail</a></td>
                </tr>
            <?php } ?>
        </table>

        <p><a class="btn secondary" href="barang.php">Kelola Data Barang</a></p>
    </div>
</body>
</html>