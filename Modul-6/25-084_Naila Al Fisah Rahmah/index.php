<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "
    SELECT transaksi.*, pelanggan.nama
    FROM transaksi
    LEFT JOIN pelanggan
    ON transaksi.pelanggan_id = pelanggan.id
");
?>

<!DOCTYPE html>
<html>

<head>

    <head>
        <title>Data Penjualan</title>

        <style>
            body {
                font-family: 'Segoe UI', Arial, sans-serif;
                background: #f5f4fa;
                padding: 30px;
                color: #252b40;
            }

            h1 {
                color: #493b78;
                text-align: center;
            }

            h2 {
                color: #493b78;
                margin-top: 30px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                background: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            }

            th {
                background: #493b78;
                color: white;
                padding: 16px;
            }

            td {
                padding: 14px;
                text-align: center;
                border-bottom: 1px solid #eeeaf5;
            }

            tr:hover {
                background: #f0edfa;
            }

            a {
                display: inline-block;
                color: white;
                background: #8064c8;
                padding: 9px 15px;
                border-radius: 7px;
                text-decoration: none;
                font-weight: bold;
            }

            a:hover {
                background: #6248a5;
            }
        </style>

    </head>

</head>

<body>

    <h1>APLIKASI PENJUALAN</h1>
    <h2>Data Transaksi</h2>
    <p>
        <a href="barang.php">Data Barang</a>
    </p>

    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Keterangan</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
            ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['waktu_transaksi']; ?></td>
                <td><?= $data['nama']; ?></td>
                <td><?= $data['keterangan']; ?></td>
                <td>Rp <?= number_format($data['total']); ?></td>
                <td>
                    <a href="detail.php?id=<?= $data['id']; ?>">
                        Detail
                    </a>
                </td>
            </tr>

        <?php } ?>

    </table>

</body>

</html>