<?php
require 'koneksi.php';

$query = "SELECT transaksi.id, transaksi.waktu_transaksi,
                 transaksi.keterangan, transaksi.total,
                 pelanggan.nama AS nama_pelanggan
          FROM transaksi
          INNER JOIN pelanggan
          ON transaksi.pelanggan_id = pelanggan.id
          ORDER BY transaksi.id ASC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>

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
        }

        th {
            background-color: #d9edf7;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .detail {
            background-color: #5cb85c;
            color: white;
            padding: 7px;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <h2>Data Transaksi</h2>

    <table>
        <tr>
            <th>No</th>
            <th>ID Transaksi</th>
            <th>Waktu Transaksi</th>
            <th>Keterangan</th>
            <th>Total</th>
            <th>Pelanggan</th>
            <th>Tindakan</th>
        </tr>

        <?php
        $no = 1;

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>

        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['waktu_transaksi']; ?></td>
            <td><?php echo htmlspecialchars($row['keterangan']); ?></td>
            <td><?php echo number_format($row['total'], 0, ',', '.'); ?></td>
            <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
            <td>
                <a href="detail_transaksi.php?id=<?php echo $row['id']; ?>"
                   class="detail">Lihat Detail</a>
            </td>
        </tr>

        <?php
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada data transaksi</td></tr>";
        }
        ?>

    </table>

</body>
</html>