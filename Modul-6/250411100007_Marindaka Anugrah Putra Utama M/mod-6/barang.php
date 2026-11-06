<?php
include 'koneksi.php';

$pesan = "";

// Hapus barang dengan pengecekan data terkait
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    $cek = mysqli_prepare($koneksi, "SELECT COUNT(*) FROM transaksi_detail WHERE barang_id = ?");
    mysqli_stmt_bind_param($cek, "i", $id);
    mysqli_stmt_execute($cek);
    mysqli_stmt_bind_result($cek, $jumlah);
    mysqli_stmt_fetch($cek);
    mysqli_stmt_close($cek);

    if ($jumlah > 0) {
        $pesan = "<span style='color:red'>Barang tidak dapat dihapus karena masih digunakan pada $jumlah transaksi.</span>";
    } else {
        $del = mysqli_prepare($koneksi, "DELETE FROM barang WHERE id = ?");
        mysqli_stmt_bind_param($del, "i", $id);
        mysqli_stmt_execute($del);
        $pesan = "<span style='color:green'>Data barang berhasil dihapus.</span>";
    }
}

$data = mysqli_query($koneksi,
    "SELECT b.*, s.nama AS supplier FROM barang b JOIN supplier s ON s.id = b.supplier_id ORDER BY b.id");
?>
<!DOCTYPE html>
<html>
<head><title>Data Barang</title></head>
<body>
<h1>Data Barang</h1>
<p><a href="transaksi.php">&laquo; Transaksi</a></p>
<?php if ($pesan) echo "<p>$pesan</p>"; ?>
<table border="1" cellpadding="5">
  <tr><th>ID</th><th>Kode</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Supplier</th><th>Aksi</th></tr>
  <?php while ($r = mysqli_fetch_assoc($data)) { ?>
  <tr>
    <td><?= $r['id'] ?></td>
    <td><?= h($r['kode_barang']) ?></td>
    <td><?= h($r['nama_barang']) ?></td>
    <td align="right"><?= number_format($r['harga'], 0, ',', '.') ?></td>
    <td><?= $r['stok'] ?></td>
    <td><?= h($r['supplier']) ?></td>
    <td><a href="barang.php?hapus=<?= $r['id'] ?>" onclick="return confirm('Hapus barang ini?')">Hapus</a></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>