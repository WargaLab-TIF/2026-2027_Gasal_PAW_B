<?php include "koneksi.php"; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Master Supplier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row" style="margin-top:20px;">
        <div class="col-md-10">
            <h3 style="color:#337ab7;">Data Master Supplier</h3>
        </div>
        <div class="col-md-2 text-right">
            <a href="tambah.php" class="btn btn-success btn-sm">Tambah Data</a>
        </div>
    </div>
    <hr>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="info">
                <th width="50">No</th>
                <th>Nama</th>
                <th>Telp</th>
                <th>Alamat</th>
                <th width="150">Tindakan</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id_supplier ASC");
        while ($row = mysqli_fetch_assoc($query)) {
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama']); ?></td>
                <td><?= htmlspecialchars($row['telp']); ?></td>
                <td><?= htmlspecialchars($row['alamat']); ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id_supplier']; ?>" class="btn btn-warning btn-xs" style="background:#e8630a;border-color:#e8630a;">Edit</a>
                    <a href="hapus.php?id=<?= $row['id_supplier']; ?>" class="btn btn-danger btn-xs"
                       onclick="return confirm('Anda yakin akan menghapus supplier ini?');">Hapus</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>