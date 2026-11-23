<?php
include "koneksi.php";

$query = mysqli_query($conn, "SELECT * FROM supplier ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h2>DATA MASTER SUPPLIER</h2>

    <a href="tambah.php" class="btn tambah">+ Tambah Supplier</a>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Supplier</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        while ($data = mysqli_fetch_assoc($query)) {
        ?>

        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($data['nama']); ?></td>
            <td><?= htmlspecialchars($data['telp']); ?></td>
            <td><?= htmlspecialchars($data['alamat']); ?></td>
            <td>
                <a href="edit.php?id=<?= $data['id']; ?>" class="btn edit">Edit</a>

                <a href="hapus.php?id=<?= $data['id']; ?>"
                   class="btn hapus"
                   onclick="return confirm('Yakin ingin menghapus data ini?')">
                   Hapus
                </a>
            </td>
        </tr>

        <?php } ?>

        <?php if (mysqli_num_rows($query) == 0) { ?>
        <tr>
            <td colspan="5">Belum ada data supplier.</td>
        </tr>
        <?php } ?>

    </table>

</div>

</body>
</html>