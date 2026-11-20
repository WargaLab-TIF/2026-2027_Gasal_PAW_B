<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id == 0) {

    $data = mysqli_query($conn, "
        SELECT transaksi.*, pelanggan.nama
        FROM transaksi
        LEFT JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
        ORDER BY transaksi.id DESC
    ");

} else {

    $transaksi = mysqli_query($conn, "
        SELECT transaksi.*, pelanggan.nama
        FROM transaksi
        LEFT JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
        WHERE transaksi.id='$id'
    ");

    $t = mysqli_fetch_assoc($transaksi);

    if (!$t) {
        die("Transaksi tidak ditemukan!");
    }

    $barang = mysqli_query($conn, "
        SELECT * FROM barang
        WHERE id NOT IN (
            SELECT barang_id FROM transaksi_detail
            WHERE transaksi_id='$id'
        )
    ");

    $detail = mysqli_query($conn, "
        SELECT transaksi_detail.*, barang.nama_barang
        FROM transaksi_detail
        JOIN barang ON transaksi_detail.barang_id = barang.id
        WHERE transaksi_id='$id'
    ");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Penjualan Cemilan</title>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 30px;
        padding: 20px;
        background-color: #fff5f8;
        color: #444;
        line-height: 1.6;
    }

    h2, h3, h4 {
        color: #d63384;
    }

    .container {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(214, 51, 132, 0.10);
    }

    .card {
        background: #fff0f5;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        background: white;
    }

    th, td {
        border: 1px solid #f5d5e3;
        padding: 12px;
        text-align: left;
    }

    th {
        background: #e879a9;
        color: white;
    }

    tr:nth-child(even) {
        background: #fff0f5;
    }

    input, select {
        padding: 9px 12px;
        margin: 5px;
        border: 1px solid #edb5cd;
        border-radius: 6px;
    }

    button, .btn {
        display: inline-block;
        padding: 9px 16px;
        background: #e879a9;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
    }

    button:hover, .btn:hover {
        background: #d63384;
        color: white;
    }

    a {
        color: #d63384;
        text-decoration: none;
    }
</style>

</head>
<body>

<div class="container">

    <a href="index.php">Kembali ke Home</a>

    <?php if ($id == 0) { ?>

        <h2>Data Transaksi</h2>

        <table>
            <tr>
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
                <td><?= htmlspecialchars($t['waktu_transaksi']) ?></td>
                <td><?= htmlspecialchars($t['nama'] ?? '-') ?></td>
                <td><?= htmlspecialchars($t['keterangan'] ?? '-') ?></td>
                <td>Rp <?= number_format($t['total'], 0, ',', '.') ?></td>
                <td>
                    <a class="btn" href="detail.php?id=<?= $t['id'] ?>">
                        Detail
                    </a>
                </td>
            </tr>

            <?php } ?>

        </table>

    <?php } else { ?>

        <a href="detail.php">Kembali ke Daftar Transaksi</a>

        <h2>Detail Transaksi #<?= $id ?></h2>

        <div class="card">
            <p>
                Pelanggan:
                <?= htmlspecialchars($t['nama'] ?? '-') ?>
            </p>

            <p>
                Tanggal:
                <?= htmlspecialchars($t['waktu_transaksi'] ?? '-') ?>
            </p>

            <p>
                Keterangan:
                <?= htmlspecialchars($t['keterangan'] ?? '-') ?>
            </p>

            <h3>
                Total: Rp <?= number_format((float)$t['total'], 0, ',', '.') ?>
            </h3>
        </div>

        <div class="card">

            <h3>Tambah Barang</h3>

            <form action="tambah.php" method="POST">

                <input type="hidden" name="transaksi_id" value="<?= $id ?>">

                <label>Nama Barang</label>

                <select name="barang" required>
                    <option value="">Pilih Barang</option>

                    <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
                        <option value="<?= $b['id'] ?>">
                            <?= htmlspecialchars($b['nama_barang']) ?>
                            - Rp <?= number_format($b['harga'], 0, ',', '.') ?>
                        </option>
                    <?php } ?>

                </select>

                <label>Jumlah</label>
                <input type="number" name="qty" min="1" required>

                <button type="submit">Tambah Barang</button>

            </form>

        </div>

        <h3>Daftar Barang</h3>

        <table>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>

            <?php
            $no = 1;
            while ($d = mysqli_fetch_assoc($detail)) {
            ?>

            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($d['nama_barang']) ?></td>
                <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                <td><?= $d['qty'] ?></td>
                <td>
                    Rp <?= number_format($d['harga'] * $d['qty'], 0, ',', '.') ?>
                </td>
            </tr>

            <?php } ?>

        </table>

    <?php } ?>

</div>

</body>
</html>
