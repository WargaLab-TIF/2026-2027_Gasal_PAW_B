<?php
require 'koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = mysqli_prepare($koneksi, "SELECT t.*,p.nama AS nama_pelanggan FROM transaksi t JOIN pelanggan p ON p.id=t.pelanggan_id WHERE t.id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$transaksi = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$transaksi) {
    die("Transaksi tidak ditemukan.");
}

$stmt = mysqli_prepare($koneksi, "SELECT td.*,b.kode_barang,b.nama_barang FROM transaksi_detail td JOIN barang b ON b.id=td.barang_id WHERE td.transaksi_id=? ORDER BY b.nama_barang");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$detail = mysqli_stmt_get_result($stmt);

$stmt2 = mysqli_prepare($koneksi, "SELECT b.id,b.kode_barang,b.nama_barang,b.harga,b.stok FROM barang b WHERE b.stok>0 AND NOT EXISTS (SELECT 1 FROM transaksi_detail td WHERE td.transaksi_id=? AND td.barang_id=b.id) ORDER BY b.nama_barang");
mysqli_stmt_bind_param($stmt2, "i", $id);
mysqli_stmt_execute($stmt2);

$barang_tersedia = mysqli_stmt_get_result($stmt2);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Detail Transaksi</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 25px;
            color: #222;
        }
        .box {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 24px;
            border-radius: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background: #263b59;
            color: white;
        }
        input,select,button {
            padding: 9px;
            margin: 5px 0;
            max-width: 100%;
        }
        button {
            background: #1769aa;
            color: white;
            border: 0;
            border-radius: 5px;
            cursor: pointer;
        }
        a {
            color: #1769aa;
        }
        .notice {
            background: #eef5ff;
            padding: 12px;
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <div class="box">
        <p><a href="index.php">← Kembali ke daftar transaksi</a></p>

        <h2>Detail Transaksi #<?= (int)$transaksi['id'] ?></h2>
        <p><b>Tanggal:</b>
        	<?= htmlspecialchars($transaksi['waktu_transaksi']) ?>
        	<br>
            <b>Pelanggan:</b>
            <?= htmlspecialchars($transaksi['nama_pelanggan']) ?>
            <br>
            <b>Keterangan:</b>
            <?= htmlspecialchars($transaksi['keterangan']) ?>
        </p>

        <h3>Barang dalam transaksi</h3>
        <table>
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>

            <?php while ($d = mysqli_fetch_assoc($detail)) { ?>
                <tr>
                    <td><?= htmlspecialchars($d['kode_barang']) ?></td>
                    <td><?= htmlspecialchars($d['nama_barang']) ?></td>
                    <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                    <td><?= (int)$d['qty'] ?></td>
                    <td>Rp <?= number_format($d['harga'] * $d['qty'], 0, ',', '.') ?></td>
                </tr>
            <?php } ?>
        </table>

        <h3>Total transaksi: Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></h3>
        <hr>
        <h3>Tambah Barang ke Transaksi</h3>
        <p class="notice">Barang yang sudah dimasukkan ke transaksi ini tidak akan muncul lagi pada dropdown.
            Barang dengan stok 0 juga tidak ditampilkan.</p>

        <?php if (mysqli_num_rows($barang_tersedia) > 0) { ?>
            <form action="simpan_detail.php" method="post">
                <input type="hidden" name="transaksi_id" value="<?= (int)$id ?>">
                <label>Pilih Barang:</label>
                <br>
                <select name="barang_id" required>
                    <option value="">-- Pilih barang --</option>
                    <?php while ($b = mysqli_fetch_assoc($barang_tersedia)) { ?>
                        <option value="<?= (int)$b['id'] ?>">
                            <?= htmlspecialchars($b['kode_barang'].' - '.$b['nama_barang'].' | Rp '.number_format($b['harga'], 0, ',', '.').' | Stok: '.$b['stok']) ?>
                        </option>
                    <?php } ?>
                </select>
                <br>
                <label>Jumlah (qty):</label><br>
                <input type="number" name="qty" min="1" value="1" required><br>
                <button type="submit">Simpan Detail</button>
            </form>

        <?php } else { ?><p>Tidak ada barang tersedia untuk ditambahkan ke transaksi ini.</p>
        <?php } ?>
    </div>
</body>
</html>