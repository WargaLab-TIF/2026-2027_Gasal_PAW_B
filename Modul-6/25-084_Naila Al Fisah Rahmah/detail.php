<?php
include 'koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($koneksi, "
    SELECT transaksi_detail.*, barang.nama_barang
    FROM transaksi_detail
    JOIN barang
    ON transaksi_detail.barang_id = barang.id
    WHERE transaksi_detail.transaksi_id = '$id'
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Detail Transaksi</title>

    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f5f4fa;
            padding: 30px;
            color: #252b40;
        }

        h1 {
            background: #172033;
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            letter-spacing: 2px;
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

<body>

    <h1>Detail Transaksi</h1>
    <a href="tambah_detail.php?id=<?= $id; ?>">
        + Tambah Barang
    </a>

    <br><br>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>

        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
            $subtotal = $data['harga'] * $data['qty'];
            ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['nama_barang']; ?></td>
                <td>Rp <?= number_format($data['harga']); ?></td>
                <td><?= $data['qty']; ?></td>
                <td>Rp <?= number_format($subtotal); ?></td>
            </tr>

        <?php } ?>

    </table>

    <p><a href="index.php">Kembali ke Data Transaksi</a></p>

</body>

</html>