<?php
include 'koneksi.php';
$owner_only = true;
include 'cek.php';

$pesan = '';

if (isset($_POST['simpan'])) {
    $id    = (int) $_POST['id'];
    $kode  = esc($_POST['kode_barang']);
    $nama  = esc($_POST['nama_barang']);
    $harga = (int) $_POST['harga'];
    $stok  = (int) $_POST['stok'];
    $sup   = (int) $_POST['supplier_id'];

    if ($id > 0) {
        mysqli_query($conn, "UPDATE barang SET kode_barang='$kode', nama_barang='$nama', harga=$harga, stok=$stok, supplier_id=$sup WHERE id=$id");
    } else {
        mysqli_query($conn, "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES ('$kode','$nama',$harga,$stok,$sup)");
    }
    header('Location: barang.php');
    exit;
}

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    if (!mysqli_query($conn, "DELETE FROM barang WHERE id=$id")) {
        $pesan = 'Barang tidak bisa dihapus karena sudah dipakai pada transaksi.';
    }
}

$edit = ['id' => 0, 'kode_barang' => '', 'nama_barang' => '', 'harga' => '', 'stok' => '', 'supplier_id' => 0];
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE id=$id")) ?: $edit;
}

$supplier = mysqli_query($conn, "SELECT * FROM supplier ORDER BY nama");
$data = mysqli_query($conn, "SELECT b.*, s.nama AS supplier FROM barang b LEFT JOIN supplier s ON s.id = b.supplier_id ORDER BY b.id");
include 'header.php';
?>
<h4>Data Barang</h4>
<?php if ($pesan) { ?><div class="alert alert-danger"><?= $pesan ?></div><?php } ?>

<form method="post" class="card card-body mb-4">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <div class="row g-2">
        <div class="col-md-2"><input name="kode_barang" class="form-control" placeholder="Kode" maxlength="10" value="<?= h($edit['kode_barang']) ?>" required></div>
        <div class="col-md-3"><input name="nama_barang" class="form-control" placeholder="Nama Barang" value="<?= h($edit['nama_barang']) ?>" required></div>
        <div class="col-md-2"><input type="number" name="harga" class="form-control" placeholder="Harga" min="0" value="<?= h($edit['harga']) ?>" required></div>
        <div class="col-md-1"><input type="number" name="stok" class="form-control" placeholder="Stok" min="0" value="<?= h($edit['stok']) ?>" required></div>
        <div class="col-md-3">
            <select name="supplier_id" class="form-select" required>
                <option value="">-- Supplier --</option>
                <?php while ($s = mysqli_fetch_assoc($supplier)) { ?>
                    <option value="<?= $s['id'] ?>" <?= $s['id'] == $edit['supplier_id'] ? 'selected' : '' ?>><?= h($s['nama']) ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-1"><button name="simpan" class="btn btn-success w-100">Simpan</button></div>
    </div>
</form>

<table class="table table-bordered table-striped">
    <tr><th>No</th><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Stok</th><th>Supplier</th><th>Aksi</th></tr>
    <?php $no = 1; while ($d = mysqli_fetch_assoc($data)) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= h($d['kode_barang']) ?></td>
        <td><?= h($d['nama_barang']) ?></td>
        <td><?= rp($d['harga']) ?></td>
        <td><?= $d['stok'] ?></td>
        <td><?= h($d['supplier']) ?></td>
        <td>
            <a href="?edit=<?= $d['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="?hapus=<?= $d['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>
<?php include 'footer.php'; ?>
