<?php
require_once "../midlewire.php";
cek_owner("../");
require_once "../koneksi.php";

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $del = mysqli_prepare($koneksi, "DELETE FROM supplier WHERE id=?");
    mysqli_stmt_bind_param($del, "i", $id);
    if (@mysqli_stmt_execute($del)) {
        header("Location: index.php");
        exit;
    } else {
        $pesan = "Supplier tidak dapat dihapus karena masih digunakan pada data barang.";
    }
    mysqli_stmt_close($del);
}

$judul = "Data Supplier";
include "../header.php";

$res = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id");
?>

<h2>Data Supplier</h2>

<?php if (isset($pesan)) { ?>
    <div class="msg"><?= htmlspecialchars($pesan) ?></div>
<?php } ?>

<a class="btn" href="tambah.php">Tambah Data</a>

<table>
    <tr>
        <th>Nama</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Aksi</th>
    </tr>
    <?php while ($r = mysqli_fetch_assoc($res)) { ?>
        <tr>
            <td><?= htmlspecialchars($r["nama"] ?? "") ?></td>
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
