<?php 
require_once "../koneksi.php"; 
$judul = "Data user"; 
include "../header.php";

if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['hapus']); 
    mysqli_query($koneksi, "DELETE FROM user WHERE id_user='$id'"); 
    header("Location: index.php");
    exit;
}

$res = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id_user"); 
?>

<h2>Data user</h2>

<a class="btn" href="tambah.php">Tambah Data</a>

<table>
    <tr>
        <th>ID User</th>
        <th>Username</th>
        <th>Password</th>
        <th>Nama</th>
        <th>Alamat</th>
        <th>HP</th>
        <th>Level</th>
        <th>Aksi</th>
    </tr>
    <?php while ($r = mysqli_fetch_assoc($res)) { ?>
        <tr>
            <td><?= htmlspecialchars($r["id_user"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["username"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["password"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["nama"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["alamat"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["hp"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["level"] ?? "") ?></td>
            <td>
                <a class="btn danger" onclick="return confirm('Hapus data?')" href="?hapus=<?= urlencode($r['id_user']) ?>">Hapus</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include "../footer.php"; ?>