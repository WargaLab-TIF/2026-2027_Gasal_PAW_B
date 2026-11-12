<?php
include "koneksi.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Ambil data transaksi
$stmt = mysqli_prepare($koneksi, "
    SELECT * FROM transaksi WHERE id = ?
");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$transaksi = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$transaksi) {
    die("Transaksi tidak ditemukan.");
}

// Ambil detail barang transaksi
$stmt = mysqli_prepare($koneksi, "
    SELECT td.*, b.kode_barang, b.nama_barang
    FROM transaksi_detail td
    JOIN barang b ON td.barang_id = b.id
    WHERE td.transaksi_id = ?
");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$detail = mysqli_stmt_get_result($stmt);

// Ambil barang yang belum dimasukkan ke transaksi
$stmt = mysqli_prepare($koneksi, "
    SELECT * FROM barang
    WHERE id NOT IN (
        SELECT barang_id
        FROM transaksi_detail
        WHERE transaksi_id = ?
    )
    ORDER BY nama_barang ASC
");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$barang = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Detail Transaksi</h2>

<p>ID Transaksi: <?= $transaksi['id']; ?></p>
<p>Tanggal: <?= $transaksi['waktu_transaksi']; ?></p>
<p>Keterangan: <?= htmlspecialchars($transaksi['keterangan'] ?? '-'); ?></p>

<hr>

<h3>Tambah Barang</h3>

<form action="tambah_detail.php" method="POST">

    <input type="hidden" name="transaksi_id"
           value="<?= $id; ?>">

    <label>Pilih Barang</label>
    <select name="barang_id" required>
        <option value="">-- Pilih Barang --</option>

        <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
            <option value="<?= $b['id']; ?>">
                <?= htmlspecialchars($b['nama_barang']); ?>
                - Rp <?= number_format($b['harga'], 0, ',', '.'); ?>
            </option>
        <?php } ?>
    </select>

    <br><br>

    <label>Jumlah (Qty)</label>
    <input type="number" name="qty" min="1" required>

    <button type="submit">Tambah Detail</button>

</form>

<hr>

<h3>Daftar Detail Barang</h3>

<table>
    <tr>
        <th>Kode Barang</th>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
    </tr>

    <?php while ($d = mysqli_fetch_assoc($detail)) { ?>
    <tr>
        <td><?= htmlspecialchars($d['kode_barang']); ?></td>
        <td><?= htmlspecialchars($d['nama_barang']); ?></td>
        <td>Rp <?= number_format($d['harga'], 0, ',', '.'); ?></td>
        <td><?= $d['qty']; ?></td>
        <td>
            Rp <?= number_format($d['harga'] * $d['qty'], 0, ',', '.'); ?>
        </td>
    </tr>
    <?php } ?>
</table>

<h3>
    Total Transaksi:
    Rp <?= number_format($transaksi['total'], 0, ',', '.'); ?>
</h3>

<br>

<a href="master-detail.php">Kembali ke Transaksi</a>

</body>
</html>
