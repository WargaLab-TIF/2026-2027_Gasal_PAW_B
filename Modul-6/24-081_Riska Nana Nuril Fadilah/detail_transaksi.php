<?php
require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    die("ID transaksi tidak ditemukan!");
}

$query_transaksi = "SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
                    FROM transaksi
                    INNER JOIN pelanggan
                    ON transaksi.pelanggan_id = pelanggan.id
                    WHERE transaksi.id = '$id'";

$result_transaksi = mysqli_query($conn, $query_transaksi);
$transaksi = mysqli_fetch_assoc($result_transaksi);

if (!$transaksi) {
    die("Data transaksi tidak ditemukan!");
}

$query = "SELECT transaksi_detail.*, barang.kode_barang,
                 barang.nama_barang
          FROM transaksi_detail
          INNER JOIN barang
          ON transaksi_detail.barang_id = barang.id
          WHERE transaksi_detail.transaksi_id = '$id'
          ORDER BY barang.id ASC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h2 {
            color: #5b9aaa;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #d9edf7;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .tambah {
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            text-decoration: none;
        }

        .kembali {
            background-color: #777;
            color: white;
            padding: 10px;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <h2>Detail Transaksi</h2>

    <p><b>ID Transaksi:</b> <?php echo $transaksi['id']; ?></p>

    <p><b>Waktu Transaksi:</b>
        <?php echo $transaksi['waktu_transaksi']; ?>
    </p>

    <p><b>Pelanggan:</b>
        <?php echo htmlspecialchars($transaksi['nama_pelanggan']); ?>
    </p>

    <p><b>Keterangan:</b>
        <?php echo htmlspecialchars($transaksi['keterangan']); ?>
    </p>

    <a href="tambah_detail.php?id=<?php echo $id; ?>" class="tambah">
        Tambah Barang
    </a>

    <table>
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>

        <?php
        $no = 1;
        $total = 0;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $subtotal = $row['harga'] * $row['qty'];
                $total += $subtotal;
        ?>

        <tr>
            <td><?php echo $no++; ?></td>

            <td><?php echo $row['kode_barang']; ?></td>

            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>

            <td><?php echo number_format($row['harga'], 0, ',', '.'); ?></td>

            <td><?php echo $row['qty']; ?></td>

            <td><?php echo number_format($subtotal, 0, ',', '.'); ?></td>
        </tr>

        <?php
            }
        } else {
            echo "<tr><td colspan='6'>Belum ada detail transaksi</td></tr>";
        }
        ?>

        <tr>
            <th colspan="5">Total Detail</th>
            <th><?php echo number_format($total, 0, ',', '.'); ?></th>
        </tr>

    </table>

    <br>

    <a href="transaksi.php" class="kembali">Kembali</a>

</body>
</html>
