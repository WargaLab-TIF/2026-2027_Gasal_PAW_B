<?php
include 'koneksi.php';

if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $cek = mysqli_query($conn, "SELECT * FROM transaksi_detail WHERE barang_id='$id'");

  if (mysqli_num_rows($cek) > 0) {
    echo "Barang tidak bisa dihapus, masih digunakan pada transaksi";
  } else {
    mysqli_query($conn, "DELETE FROM barang WHERE id='$id'");
    echo "Barang berhasil dihapus";
  }
}
?>
<h1>Data Barang</h1>
<a href="index.php">Data Transaksi</a>
<br><br>
<table border="1">
  <tr>
    <th>ID</th>
    <th>Kode</th>
    <th>Nama Barang</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Aksi</th>
  </tr>
  <?php
  $result = mysqli_query($conn, "SELECT * FROM barang");
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['kode_barang'] . "</td>";
    echo "<td>" . $row['nama_barang'] . "</td>";
    echo "<td>" . $row['harga'] . "</td>";
    echo "<td>" . $row['stok'] . "</td>";
    echo "<td><a href='barang.php?hapus=" . $row['id'] . "'>Hapus</a></td>";
    echo "</tr>";
  }
  ?>
</table>