<?php
include 'koneksi.php';
$q = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY id");
?>
<!DOCTYPE html>
<html>
<head><title>Data Barang</title></head>
<body>
<h2>Data Barang</h2>
<table border="1" cellpadding="6">
  <tr><th>Kode</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr>
  <?php while ($r = mysqli_fetch_assoc($q)): ?>
  <tr>
    <td><?= $r['kode_barang'] ?></td>
    <td><?= $r['nama_barang'] ?></td>
    <td><?= number_format($r['harga']) ?></td>
    <td><?= $r['stok'] ?></td>
    <td>
      <a href="hapus_barang.php?id=<?= $r['id'] ?>"
         onclick="return confirm('Yakin hapus barang ini?')">Hapus</a>
    </td>
  </tr>
  <?php endwhile; ?>
</table>
</body>
</html>