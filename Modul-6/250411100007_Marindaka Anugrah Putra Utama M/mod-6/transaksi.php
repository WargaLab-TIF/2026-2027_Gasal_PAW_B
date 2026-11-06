<?php
include 'koneksi.php';

// Tambah transaksi
if (isset($_POST['simpan'])) {
    $stmt = mysqli_prepare($koneksi,
        "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES (?, ?, 0, ?)");
    mysqli_stmt_bind_param($stmt, "sss", $_POST['waktu'], $_POST['keterangan'], $_POST['pelanggan_id']);
    mysqli_stmt_execute($stmt);
    header("Location: detail.php?id=" . mysqli_insert_id($koneksi));
    exit;
}

$pelanggan = mysqli_query($koneksi, "SELECT id, nama FROM pelanggan ORDER BY nama");
$data = mysqli_query($koneksi,
    "SELECT t.id, t.waktu_transaksi, t.keterangan, t.total, p.nama
     FROM transaksi t JOIN pelanggan p ON p.id = t.pelanggan_id ORDER BY t.id DESC");
?>
<!DOCTYPE html>
<html>
<head><title>Data Transaksi (Master)</title></head>
<body>
<h1>Data Transaksi</h1>
<p><a href="barang.php">Kelola Barang</a></p>

<h3>Tambah Transaksi</h3>
<form method="post">
  Tanggal: <input type="date" name="waktu" required>
  Pelanggan:
  <select name="pelanggan_id" required>
    <option value="">pilih</option>
    <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>
      <option value="<?= h($p['id']) ?>"><?= h($p['nama']) ?></option>
    <?php } ?>
  </select>
  Keterangan: <input type="text" name="keterangan">
  <button type="submit" name="simpan">Simpan &amp; Isi Detail</button>
</form>

<h3>Daftar Transaksi</h3>
<table border="1" cellpadding="5">
  <tr><th>ID</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total</th><th>Aksi</th></tr>
  <?php while ($r = mysqli_fetch_assoc($data)) { ?>
  <tr>
    <td><?= $r['id'] ?></td>
    <td><?= h($r['waktu_transaksi']) ?></td>
    <td><?= h($r['nama']) ?></td>
    <td><?= h($r['keterangan']) ?></td>
    <td align="right"><?= number_format($r['total'], 0, ',', '.') ?></td>
    <td><a href="detail.php?id=<?= $r['id'] ?>">Lihat / Isi Detail</a></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>