<?php
require_once "../midlewire.php";
cek_owner("../");
require_once "../koneksi.php";

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $del = mysqli_prepare($koneksi, "DELETE FROM pelanggan WHERE id=?");
    mysqli_stmt_bind_param($del, "s", $id);
    if (@mysqli_stmt_execute($del)) {
        header("Location: index.php");
        exit;
    } else {
        $pesan = "Pelanggan tidak dapat dihapus karena masih digunakan pada data transaksi.";
    }
    mysqli_stmt_close($del);
}

$judul = "Data Pelanggan";
include "../header.php";

$res = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY id");
?>

<h2>Data Pelanggan</h2>

<?php if (isset($pesan)) { ?>
    <div class="msg"><?= htmlspecialchars($pesan) ?></div>
<?php } ?>

<a class="btn" href="tambah.php">Tambah Data</a>

<table>
    <tr>
        <th>ID Pelanggan</th>
        <th>Nama</th>
        <th>Jenis Kelamin</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>
    <?php while ($r = mysqli_fetch_assoc($res)) { ?>
        <tr>
            <td><?= htmlspecialchars($r["id"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["nama"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["jenis_kelamin"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["telp"] ?? "") ?></td>
            <td><?= htmlspecialchars($r["alamat"] ?? "") ?></td>
            <td>
                <a class="btn warning" href="edit.php?id=<?= urlencode($r['id']) ?>">Edit</a>
                <a class="btn danger" onclick="return confirm('Hapus data?')" href="?hapus=<?= urlencode($r['id']) ?>">Hapus</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include "../footer.php"; ?>
