<?php
require_once "../midlewire.php";
cek_owner("../");
require_once "../koneksi.php";

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    if ($id === (int)($_SESSION['id_user'] ?? 0)) {
        $pesan = "Tidak dapat menghapus akun yang sedang digunakan untuk login.";
    } else {
        $del = mysqli_prepare($koneksi, "DELETE FROM user WHERE id_user=?");
        mysqli_stmt_bind_param($del, "i", $id);
        mysqli_stmt_execute($del);
        mysqli_stmt_close($del);
        header("Location: index.php");
        exit;
    }
}

$judul = "Data User";
include "../header.php";

$res = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id_user");
?>

<h2>Data User</h2>

<?php if (isset($pesan)) { ?>
    <div class="msg"><?= htmlspecialchars($pesan) ?></div>
<?php } ?>

<a class="btn" href="tambah.php">Tambah Data</a>

<table>
    <tr>
        <th>ID User</th>
        <th>Username</th>
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
            <td><?= htmlspecialchars($r["nama"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["alamat"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["hp"] ?? "") ?></td>
            <td><?= ((int)$r["level"] === 1) ? '1 (Owner)' : (((int)$r["level"] === 2) ? '2 (Kasir)' : htmlspecialchars($r["level"])) ?></td>
            <td>
                <a class="btn warning" href="edit.php?id=<?= urlencode($r['id_user']) ?>">Edit</a>
                <a class="btn danger" onclick="return confirm('Hapus data?')" href="?hapus=<?= urlencode($r['id_user']) ?>">Hapus</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include "../footer.php"; ?>
