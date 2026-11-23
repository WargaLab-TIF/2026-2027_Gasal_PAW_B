<?php
include 'koneksi.php';
$q = mysqli_query($koneksi, "SELECT t.*, p.nama AS nama_pelanggan
                             FROM transaksi t
                             LEFT JOIN pelanggan p ON p.id = t.pelanggan_id
                             ORDER BY t.id");
?>
<!DOCTYPE html>
<html>
<head><title>Daftar Transaksi</title></head>
<body>
<h2>Daftar Transaksi</h2>
<table border="1" cellpadding="6">
  <tr><th>ID</th><th>Tanggal</th><th>Pelanggan</th><th>Total</th><th>Aksi</th></tr>
  <?php while ($r = mysqli_fetch_assoc($q)): ?>
  <tr>
    <td><?= $r['id'] ?></td>
    <td><?= $r['waktu_transaksi'] ?></td>
    <td><?= $r['nama_pelanggan'] ?></td>
    <td>Rp <?= number_format($r['total']) ?></td>
    <td><a href="detail.php?id=<?= $r['id'] ?>">Kelola Detail</a></td>
  </tr>
  <?php endwhile; ?>
</table>
</body>
</html>