
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['level'] != 1) {
    header("Location: ../index.php");
    exit;
}

require_once '../koneksi.php';

$query = mysqli_query($conn, "SELECT id_user, username, nama, alamat, hp, level FROM `user` ORDER BY id_user DESC");
include '../navbar.php';
?>

<style>
.container {
    max-width: 1100px;
    margin: 30px auto;
    padding: 0 20px;
}
.card {
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,.08);
    overflow-x: auto;
}
h2 { color: #1e3a5f; }
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}
th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}
th { background: #1e3a5f; color: white; }
tr:nth-child(even) { background: #f4f6f9; }
.btn {
    display: inline-block;
    padding: 9px 13px;
    border-radius: 5px;
    color: white;
    text-decoration: none;
    font-size: 13px;
}
.tambah { background: #198754; }
.edit { background: #0d6efd; }
.hapus { background: #dc3545; }
</style>

<div class="container">
<div class="card">
    <h2>Data User</h2>
    <p>Daftar pengguna aplikasi penjualan.</p>

    <a href="tambah.php" class="btn tambah">+ Tambah User</a>

    <table>
        <tr>
            <th>No</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Level</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1; ?>
        <?php while ($data = mysqli_fetch_assoc($query)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= htmlspecialchars($data['username']); ?></td>
            <td><?= htmlspecialchars($data['nama']); ?></td>
            <td><?= htmlspecialchars($data['alamat']); ?></td>
            <td><?= htmlspecialchars($data['hp']); ?></td>
            <td><?= $data['level'] == 1 ? 'Owner' : 'Kasir'; ?></td>
            <td>
                <a class="btn edit" href="edit.php?id=<?= $data['id_user']; ?>">Edit</a>
                <a class="btn hapus" href="hapus.php?id=<?= $data['id_user']; ?>"
                   onclick="return confirm('Hapus user ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</div>
