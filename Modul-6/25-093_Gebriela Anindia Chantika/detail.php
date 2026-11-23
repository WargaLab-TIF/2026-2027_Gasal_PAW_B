<?php
require_once "koneksi.php";

$id = (int) $_GET['id'];

// Mengambil data transaksi
$query = mysqli_query($koneksi, "
    SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
    FROM transaksi
    JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    WHERE transaksi.id = $id
");

$transaksi = mysqli_fetch_assoc($query);

if (!$transaksi) {
    die("Transaksi tidak ditemukan.");
}

$query_detail = mysqli_query($koneksi, "
    SELECT transaksi_detail.*, barang.kode_barang, barang.nama_barang
    FROM transaksi_detail
    JOIN barang ON transaksi_detail.barang_id = barang.id
    WHERE transaksi_detail.transaksi_id = $id
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h2>Detail Transaksi</h2>

    <div class="card">
        <p><strong>ID Transaksi:</strong> <?= $transaksi['id']; ?></p>
        <p><strong>Pelanggan:</strong> <?= htmlspecialchars($transaksi['nama_pelanggan']); ?></p>
        <p><strong>Waktu Transaksi:</strong> <?= $transaksi['waktu_transaksi']; ?></p>
        <p><strong>Keterangan:</strong> <?= htmlspecialchars($transaksi['keterangan']); ?></p>
    </div>

    <br>

    <a href="tambah.php?id=<?= $id; ?>" class="button">
        + Tambah Barang
    </a>

    <br><br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
            $total = 0;

            if (mysqli_num_rows($query_detail) > 0) :
                while ($detail = mysqli_fetch_assoc($query_detail)) :
                    $subtotal = $detail['harga'] * $detail['qty'];
                    $total += $subtotal;
            ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($detail['kode_barang']); ?></td>
                <td><?= htmlspecialchars($detail['nama_barang']); ?></td>
                <td>Rp <?= number_format($detail['harga'], 0, ',', '.'); ?></td>
                <td><?= $detail['qty']; ?></td>
                <td>Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
            </tr>

            <?php
                endwhile;
            else :
            ?>

            <tr>
                <td colspan="7">Belum ada barang dalam transaksi ini.</td>
            </tr>

            <?php endif; ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="5" class="text-right">TOTAL TRANSAKSI</th>
                <th>Rp <?= number_format($total, 0, ',', '.'); ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <br>

    <a href="index.php" class="button">Kembali</a>

</div>

</body>
</html>