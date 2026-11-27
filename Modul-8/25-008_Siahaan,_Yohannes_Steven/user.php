<?php
require "koneksi.php";
include "midlewire.php";
cekOwner();
require "fungsi.php";

$data = getAllUser();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data User</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h2>Data Master User</h2>
    <a href="tambah_user.php">+ Tambah User</a><br><br>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>No. HP</th>
            <th>Level</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; foreach ($data as $row): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row["username"]) ?></td>
            <td><?= htmlspecialchars($row["nama"]) ?></td>
            <td><?= htmlspecialchars($row["alamat"]) ?></td>
            <td><?= htmlspecialchars($row["hp"]) ?></td>
            <td><?= $row["level"] == 1 ? "1 (Owner)" : "2 (Kasir)" ?></td>
            <td>
                <a href="edit_user.php?id=<?= $row["id_user"] ?>">Edit</a> |
                <a href="hapus_user.php?id=<?= $row["id_user"] ?>" onclick="return confirm('Yakin hapus user ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
