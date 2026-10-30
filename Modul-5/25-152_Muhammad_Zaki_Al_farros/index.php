<?php
include "koneksi.php";

$query = "SELECT id, nama, telp, alamat FROM supplier";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Data Master Supplier</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

  <div class="header">
    <h2>Data Master Supplier</h2>
    <a href="tambah.php" class="btn btn-tambah">Tambah Data</a>
  </div>

  <table>
    <tr>
      <th width="50">No</th>
      <th>Nama</th>
      <th>Telp</th>
      <th>Alamat</th>
      <th width="130">Tindakan</th>
    </tr>

    <?php
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
      <td><?php echo $no; ?></td>
      <td><?php echo $row["nama"]; ?></td>
      <td><?php echo $row["telp"]; ?></td>
      <td><?php echo $row["alamat"]; ?></td>
      <td>
        <a href="edit.php?id=<?php echo $row["id"]; ?>" class="btn btn-kecil btn-edit">Edit</a>
        <a href="hapus.php?id=<?php echo $row["id"]; ?>" class="btn btn-kecil btn-hapus"
           onclick="return confirm('Anda yakin akan menghapus supplier ini?')">Hapus</a>
      </td>
    </tr>
    <?php
      $no++;
    }
    ?>
  </table>

</div>
</body>
</html>