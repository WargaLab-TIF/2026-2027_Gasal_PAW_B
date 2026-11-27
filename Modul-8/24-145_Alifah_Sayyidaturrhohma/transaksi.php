<?php
require_once "middleware.php";
cekLogin();

include "koneksi.php";

$query = mysqli_query($conn, "SELECT transaksi.*, pelanggan.nama
FROM transaksi
JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
ORDER BY transaksi.id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Data Transaksi</h2>
    <div>
        <a href="index.php">&laquo; Kembali ke Dashboard</a>
        <?php if (isset($_SESSION['level']) && (int)$_SESSION['level'] === 1): ?>
            &nbsp;|&nbsp; <a href="barang.php">Kelola Data Barang &raquo;</a>
        <?php endif; ?>
    </div>
    <br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>ID Transaksi</th>
            <th>Waktu Transaksi</th>
            <th>Pelanggan</th>
            <th>Keterangan</th>
            <th>Total</th>
            <th>Detail</th>
        </tr>

        <?php
        $no = 1;

        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['id']; ?></td>
            <td><?php echo $data['waktu_transaksi']; ?></td>
            <td><?php echo $data['nama']; ?></td>
            <td><?php echo $data['keterangan']; ?></td>
            <td><?php echo $data['total']; ?></td>
            <td>
                <a href="detail.php?id=<?php echo $data['id']; ?>">Lihat Detail</a>
            </td>
        </tr>

        <?php } ?>

    </table>

</body>
</html>

