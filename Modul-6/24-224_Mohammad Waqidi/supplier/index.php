<?php 
require_once "../koneksi.php"; 
$judul = "Data supplier"; 
include "../header.php";

if (isset($_GET['hapus'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['hapus']); 
    mysqli_query($koneksi, "DELETE FROM supplier WHERE id='$id'"); 
    header("Location: index.php");
    exit;
}

$res = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id"); 
?>

<h2>Data supplier</h2>

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
                <a class="btn danger" onclick="return confirm('Hapus data?')" href="?hapus=<?= urlencode($r['id']) ?>">Hapus</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include "../footer.php"; ?>