<?php 
require_once "../koneksi.php"; 
$judul = "Data Barang"; 
include "../header.php";

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $cek = mysqli_prepare($koneksi, "SELECT COUNT(*) FROM transaksi_detail WHERE barang_id=?");
    mysqli_stmt_bind_param($cek, "i", $id);
    mysqli_stmt_execute($cek);
    mysqli_stmt_bind_result($cek, $jumlah);
    mysqli_stmt_fetch($cek);
    mysqli_stmt_close($cek);

    if ($jumlah > 0) {
        $pesan = "Barang tidak dapat dihapus karena masih digunakan pada transaksi.";
    } else {
        mysqli_query($koneksi, "DELETE FROM barang WHERE id=$id");
        $pesan = "Barang berhasil dihapus.";
    }
}

$r = mysqli_query($koneksi, "SELECT b.*, s.nama AS supplier FROM barang b LEFT JOIN supplier s ON b.supplier_id=s.id ORDER BY b.id");
?>

<h2>Data Barang</h2>

<?php if (isset($pesan)) { ?>
    <div class="msg"><?= htmlspecialchars($pesan) ?></div>
<?php } ?>

<a class="btn" href="tambah.php">Tambah Barang</a>

<table>
    <tr>
        <th>ID</th>
        <th>Kode</th>
        <th>Nama</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Supplier</th>
        <th>Aksi</th>
    </tr>
    <?php while ($d = mysqli_fetch_assoc($r)) { ?>
        <tr>
            <td><?= $d['id'] ?></td>
            <td><?= htmlspecialchars($d['kode_barang']) ?></td>
            <td><?= htmlspecialchars($d['nama_barang']) ?></td>
            <td><?= number_format($d['harga']) ?></td>
            <td><?= $d['stok'] ?></td>
            <td><?= htmlspecialchars($d['supplier'] ?? '-') ?></td>
            <td>
                <a class="btn danger" onclick="return confirm('Hapus barang ini?')" href="?hapus=<?= $d['id'] ?>">Hapus</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include "../footer.php"; ?>