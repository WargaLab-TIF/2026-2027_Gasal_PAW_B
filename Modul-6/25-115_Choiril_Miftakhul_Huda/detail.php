<?php
include 'koneksi.php';

$id = $_GET['id'];

if (isset($_POST['simpan'])) {
  $barang_id = $_POST['barang_id'];
  $qty = $_POST['qty'];

  $barang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT harga FROM barang WHERE id='$barang_id'"));
  $harga = $barang['harga'];

  mysqli_query($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES ('$id', '$barang_id', '$harga', '$qty')");
  mysqli_query($conn, "UPDATE transaksi SET total = (SELECT SUM(harga * qty) FROM transaksi_detail WHERE transaksi_id='$id') WHERE id='$id'");
}

$transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaksi WHERE id='$id'"));
?>
<h1>Detail Transaksi</h1>
<a href="index.php">Kembali</a>

<h3>Master</h3>
<table border="1">
  <tr><td>ID</td><td><?php echo $transaksi['id']; ?></td></tr>
  <tr><td>Waktu</td><td><?php echo $transaksi['waktu_transaksi']; ?></td></tr>
  <tr><td>Keterangan</td><td><?php echo $transaksi['keterangan']; ?></td></tr>
  <tr><td>Pelanggan</td><td><?php echo $transaksi['pelanggan_id']; ?></td></tr>
  <tr><td>Total</td><td><?php echo $transaksi['total']; ?></td></tr>
</table>

<h3>Detail</h3>
<table border="1">
  <tr>
    <th>Barang</th>
    <th>Harga</th>
    <th>Qty</th>
  </tr>
  <?php
  $detail = mysqli_query($conn, "SELECT b.nama_barang, d.harga, d.qty FROM transaksi_detail d JOIN barang b ON b.id = d.barang_id WHERE d.transaksi_id='$id'");
  while ($row = mysqli_fetch_assoc($detail)) {
    echo "<tr>";
    echo "<td>" . $row['nama_barang'] . "</td>";
    echo "<td>" . $row['harga'] . "</td>";
    echo "<td>" . $row['qty'] . "</td>";
    echo "</tr>";
  }
  ?>
</table>

<h3>Tambah Barang</h3>
<form method="post">
  <select name="barang_id">
    <?php
    $barang = mysqli_query($conn, "SELECT * FROM barang WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id='$id')");
    while ($row = mysqli_fetch_assoc($barang)) {
      echo "<option value='" . $row['id'] . "'>" . $row['nama_barang'] . "</option>";
    }
    ?>
  </select>
  Qty: <input type="number" name="qty" value="1" min="1">
  <button type="submit" name="simpan">Simpan</button>
</form>