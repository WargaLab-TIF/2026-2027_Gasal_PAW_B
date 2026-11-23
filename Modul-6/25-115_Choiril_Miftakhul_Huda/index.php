<?php include 'koneksi.php'; ?>
<h1>Data Transaksi</h1>
<a href="barang.php">Data Barang</a>
<br><br>
<table border="1">
  <tr>
    <th>ID</th>
    <th>Waktu</th>
    <th>Keterangan</th>
    <th>Total</th>
    <th>Pelanggan</th>
    <th>Aksi</th>
  </tr>
  <?php
  $result = mysqli_query($conn, "SELECT * FROM transaksi");
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['waktu_transaksi'] . "</td>";
    echo "<td>" . $row['keterangan'] . "</td>";
    echo "<td>" . $row['total'] . "</td>";
    echo "<td>" . $row['pelanggan_id'] . "</td>";
    echo "<td><a href='detail.php?id=" . $row['id'] . "'>Detail</a></td>";
    echo "</tr>";
  }
  ?>
</table>