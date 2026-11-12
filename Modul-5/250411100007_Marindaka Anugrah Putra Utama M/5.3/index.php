<?php include "koneksi.php"; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
<div class="container">
  <a href="tambah.php" class="btn btn-success btn-sm pull-right">Tambah Data</a>
  <h3>Data Master Supplier</h3>
  <hr>
  <table class="table table-bordered">
    <tr class="info"><th>No</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Tindakan</th></tr>
<?php
$result = mysqli_query($conn, "SELECT * FROM supplier");
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>" . $no++ . "</td>";
  echo "<td>" . $row["nama"] . "</td>";
  echo "<td>" . $row["telp"] . "</td>";
  echo "<td>" . $row["alamat"] . "</td>";
  echo "<td>
          <a href='edit.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Edit</a>
          <a href='hapus.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'
             onclick=\"return confirm('Anda yakin akan menghapus supplier ini?')\">Hapus</a>
        </td>";
  echo "</tr>";
}
?>
  </table>
</div>
