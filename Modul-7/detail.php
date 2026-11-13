<?php
include 'koneksi.php';

$baru = isset($_GET['baru']);
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");

if (!$baru && $id > 0) {
    $transaksi = mysqli_query($conn, "
        SELECT transaksi.*, pelanggan.nama
        FROM transaksi
        LEFT JOIN pelanggan ON transaksi.pelanggan_id=pelanggan.id
        WHERE transaksi.id='$id'
    ");

    $t = mysqli_fetch_assoc($transaksi);

    if (!$t) {
        die("Transaksi tidak ditemukan!");
    }
}

if (!$baru && $id > 0) {
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
        JOIN barang ON transaksi_detail.barang_id=barang.id
        WHERE transaksi_id='$id'
    ");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
   
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

    <a href="index.php" class="btn btn-secondary mb-3">Kembali</a>

    <?php if ($baru) { ?>

        <h2>Tambah Transaksi</h2>

        <div class="card p-3 mb-4">
          <form action="simpan.php" method="POST">

    <input type="hidden" name="transaksi_id" value="<?= $id ?>">

    <label>Nama Barang</label>
    <select name="barang" required>
        <option value="">Pilih Barang</option>
        <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
            <option value="<?= $b['id'] ?>">
                <?= $b['nama_barang'] ?>
            </option>
        <?php } ?>
    </select>

    <label>Jumlah</label>
    <input type="number" name="qty" min="1" required>

    <button type="submit">Simpan Barang</button>
</form>  
        </div>

    <?php } else { ?>

        <h2>Detail Transaksi #<?= $id ?></h2>

        <div class="card p-3 mb-4">
            <p>Pelanggan: <?= htmlspecialchars($t['nama'] ?? '-') ?></p>
            <p>Tanggal: <?= $t['waktu_transaksi'] ?></p>
            <p>Keterangan: <?= htmlspecialchars($t['keterangan'] ?? '-') ?></p>

            <h4>Total: Rp <?= number_format($t['total'],0,',','.') ?></h4>
        </div>

        <div class="card p-3 mb-4">
            <h4>Tambah Barang</h4>

            <form action="tambah.php" method="POST">

                <input type="hidden" name="transaksi_id" value="<?= $id ?>">

                <label>Nama Barang</label>
                <select name="barang" class="form-control mb-3" required>
                    <option value="">Pilih Barang</option>

                    <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
                        <option value="<?= $b['id'] ?>">
                            <?= htmlspecialchars($b['nama_barang']) ?>
                            - Rp <?= number_format($b['harga']) ?>
                        </option>
                    <?php 
                } 
                ?>
                </select>
                <label>Jumlah</label>
                <input type="number" name="qty" min="1"
                       class="form-control mb-3" required>
                <button class="btn btn-success">Tambah Barang</button>
            </form>
        </div>

        <h4>Daftar Barang</h4>

        <table class="table table-bordered">
            <tr class="table-dark">
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
                <td>Rp <?= number_format($d['harga']) ?></td>
                <td><?= $d['qty'] ?></td>
                <td>Rp <?= number_format($d['harga'] * $d['qty']) ?></td>
            </tr>
            <?php 
        } 
        ?>
        </table>
    <?php 
} 
?>

</div>
</body>
</html>
