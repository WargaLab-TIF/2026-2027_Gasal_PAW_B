<?php
include 'koneksi.php';

$data = mysqli_query($conn, "
    SELECT transaksi.*, pelanggan.nama
    FROM transaksi
    LEFT JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    ORDER BY transaksi.id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Penjualan Cemilan</title>
   
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 30px;
        padding: 20px;
        background-color: #fff5f8;
        color: #444;
        line-height: 1.6;
    }

    h2, h3 {
        color: #d63384;
        margin-bottom: 15px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(214, 51, 132, 0.10);
    }

    th, td {
        border: 1px solid #f5d5e3;
        padding: 12px;
        color: #444;
        text-align: left;
    }

    th {
        background-color: #e879a9;
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #fff0f5;
    }

    tr:hover {
        background-color: #fce0eb;
        transition: 0.2s;
    }

    input, select {
        padding: 9px 12px;
        margin: 5px;
        border: 1px solid #edb5cd;
        border-radius: 6px;
        color: #444;
        background-color: white;
        outline: none;
        transition: 0.2s;
    }

    input:focus, select:focus {
        border-color: #e879a9;
        box-shadow: 0 0 5px rgba(232, 121, 169, 0.3);
    }

    button {
        padding: 9px 16px;
        background-color: #e879a9;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.2s;
    }

    button:hover {
        background-color: #d63384;
        transform: translateY(-1px);
    }

    a {
        color: #d63384;
        text-decoration: none;
        transition: 0.2s;
    }

    a:hover {
        color: #ad2165;
        text-decoration: underline;
    }
</style>

</head>
<body>

<div class="container mt-4">

    <h2>Penjualan Cemilan</h2>
    <p>Aplikasi Transaksi Penjualan Cemilan</p>
    <a href="barang.php">Data Barang</a>
    <table class="table table-bordered">
        <tr class="table-dark">
            <th>No</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Keterangan</th>
            <th>Total</th>
            <th>Detail</th>
        </tr>

        <?php
        $no = 1;
        while ($t = mysqli_fetch_assoc($data)) {
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $t['waktu_transaksi'] ?></td>
            <td><?= htmlspecialchars($t['nama'] ?? '-') ?></td>
            <td><?= htmlspecialchars($t['keterangan'] ?? '-') ?></td>
            <td>Rp <?= number_format($t['total'],0,',','.') ?></td>

            <td>
                <a href="detail.php?id=<?= $t['id'] ?>"
                   class="btn btn-info btn-sm">Detail</a>
            </td>
        </tr>
        <?php } ?>

    </table>

</div>
</body>
</html>
