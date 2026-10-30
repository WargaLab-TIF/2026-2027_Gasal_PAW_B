<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html>
<head>
  <title>Data Master Supplier</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
  <div class="page-header">
    <a href="tambah.php" class="btn btn-success pull-right">Tambah Data</a>
    <h2 style="color:#337ab7;">Data Master Supplier</h2>
  </div>

  <table class="table table-bordered">
    <tr class="info">
      <th>No</th>
      <th>Nama</th>
      <th>Telp</th>
      <th>Alamat</th>
      <th>Tindakan</th>
    </tr>
    <?php
    $query = "SELECT id, nama, telp, alamat FROM supplier";
    $result = mysqli_query($conn, $query);
    $no = 1;

    while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
      <td><?php echo $no; ?></td>
      <td><?php echo $row["nama"]; ?></td>
      <td><?php echo $row["telp"]; ?></td>
      <td><?php echo $row["alamat"]; ?></td>
      <td>
        <a href="edit.php?id=<?php echo $row["id"]; ?>" class="btn btn-warning btn-sm">Edit</a>
        <a href="hapus.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus supplier ini?')">Hapus</a>
      </td>
    </tr>
    <?php
      $no = $no + 1;
    }
    ?>
  </table>
</div>
</body>
</html>
