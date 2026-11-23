<?php
include 'koneksi.php';
$id = (int)($_GET['id'] ?? 0);

$trx = mysqli_fetch_assoc(mysqli_query($koneksi,
    "SELECT t.*, p.nama AS nama_pelanggan
     FROM transaksi t
     LEFT JOIN pelanggan p ON p.id = t.pelanggan_id
     WHERE t.id = $id"));
if (!$trx) {
    die("Transaksi tidak ditemukan.");
}

$sudah = [];
$qs = mysqli_query($koneksi, "SELECT barang_id FROM transaksi_detail WHERE transaksi_id = $id");
while ($r = mysqli_fetch_assoc($qs)) {
    $sudah[] = $r['barang_id'];
}

$barang = mysqli_query($koneksi, "SELECT id, kode_barang, nama_barang FROM barang ORDER BY nama_barang");
$detail = mysqli_query($koneksi,
    "SELECT d.*, b.nama_barang
     FROM transaksi_detail d
     JOIN barang b ON b.id = d.barang_id
     WHERE d.transaksi_id = $id");

$pesan = $_GET['pesan'] ?? '';
?>
<!DOCTYPE html>
<html>
<head><title>Detail Transaksi</title></head>
<body>
<h2>Transaksi #<?= $trx['id'] ?></h2>
<p>
  Tanggal: <?= $trx['waktu_transaksi'] ?><br>
  Pelanggan: <?= $trx['nama_pelanggan'] ?><br>
  Total: <strong>Rp <?= number_format($trx['total']) ?></strong>
</p>

<?php if ($pesan): ?>
  <p style="color:red;"><strong><?= htmlspecialchars($pesan) ?></strong></p>
<?php endif; ?>

<h3>Tambah Detail Barang</h3>
<form method="post" action="simpan_detail.php">
  <input type="hidden" name="transaksi_id" value="<?= $id ?>">
  <select name="barang_id" required>
    <option value="">-- Pilih Barang --</option>
    <?php while ($b = mysqli_fetch_assoc($barang)):
        $disabled = in_array($b['id'], $sudah) ? 'disabled' : ''; ?>
      <option value="<?= $b['id'] ?>" <?= $disabled ?>>
        <?= $b['kode_barang'] ?> - <?= $b['nama_barang'] ?>
        <?= $disabled ? '(sudah dipilih)' : '' ?>
      </option>
    <?php endwhile; ?>
  </select>
  Qty: <input type="number" name="qty" min="1" value="1" required>
  <button type="submit">Simpan</button>
</form>

<h3>Daftar Detail</h3>
<table border="1" cellpadding="6">
  <tr><th>Barang</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
  <?php while ($d = mysqli_fetch_assoc($detail)): ?>
  <tr>
    <td><?= $d['nama_barang'] ?></td>
    <td><?= number_format($d['harga']) ?></td>
    <td><?= $d['qty'] ?></td>
    <td><?= number_format($d['harga'] * $d['qty']) ?></td>
  </tr>
  <?php endwhile; ?>
</table>
<p><a href="transaksi.php">Kembali</a></p>
</body>
</html>