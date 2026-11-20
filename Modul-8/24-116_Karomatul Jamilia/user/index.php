<?php
$base = "../";
include "../midlewire.php";
require "../fungsi.php";
hanyaOwner();

$data = getUser();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data User</title>
</head>
<body>
    <?php include "../components/navbar.php"; ?>
    <h2>Data User</h2>
    <a href="tambah.php">+ Tambah user</a>
    <br><br>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>HP</th>
            <th>Level</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; foreach ($data as $row) : ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row["username"]) ?></td>
            <td><?= htmlspecialchars($row["nama"]) ?></td>
            <td><?= htmlspecialchars($row["alamat"]) ?></td>
            <td><?= htmlspecialchars($row["hp"]) ?></td>
            <td><?= $row["level"] == 1 ? "Owner" : "Kasir" ?></td>
            <td>
                <a href="edit.php?id=<?= $row["id_user"] ?>">Edit</a> |
                <a href="hapus.php?id=<?= $row["id_user"] ?>" onclick="return confirm('Anda yakin ingin menghapus user ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
