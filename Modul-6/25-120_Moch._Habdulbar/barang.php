<?php
include "koneksi.php";

$pesan = "";
$warna = "";

if (isset($_POST['hapus'])) {
    $id = (int) $_POST['id'];

    // Cek apakah barang sudah dipakai di transaksi_detail
    $cek = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah
                                                      FROM transaksi_detail
                                                      WHERE barang_id = $id"));

    if ($cek['jumlah'] > 0) {
        $pesan = "Barang tidak bisa dihapus karena masih digunakan pada transaksi.";
        $warna = "danger";
    } else {
        mysqli_query($koneksi, "DELETE FROM barang WHERE id = $id");
        $pesan = "Barang berhasil dihapus.";
        $warna = "success";
    }
}

$barang = mysqli_query($koneksi, "SELECT b.*, s.nama AS supplier
                                  FROM barang b
                                  JOIN supplier s ON s.id = b.supplier_id
                                  ORDER BY b.id");

$judul = "Data Barang";
$halaman = "barang";
include "layout.php";
tampilHeader($judul, $halaman);
?>

<?php if ($pesan != "") { ?>
    <div class="alert alert-<?= $warna ?>"><?= $pesan ?></div>
<?php } ?>

<div class="card">
    <div class="card-header">Data Barang</div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Supplier</th>
                <th>Aksi</th>
            </tr>
            <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
            <tr>
                <td><?= $b['kode_barang'] ?></td>
                <td><?= htmlspecialchars($b['nama_barang']) ?></td>
                <td>Rp <?= number_format($b['harga']) ?></td>
                <td><?= $b['stok'] ?></td>
                <td><?= htmlspecialchars($b['supplier']) ?></td>
                <td>
                    <form method="post" onsubmit="return confirm('Yakin hapus barang ini?')">
                        <input type="hidden" name="id" value="<?= $b['id'] ?>">
                        <button type="submit" name="hapus" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php tampilFooter(); ?>
