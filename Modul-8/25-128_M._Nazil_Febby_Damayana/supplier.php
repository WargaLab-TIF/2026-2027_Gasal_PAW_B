<?php
include 'koneksi.php';
$owner_only = true;
include 'cek.php';

$pesan = '';

if (isset($_POST['simpan'])) {
    $id     = (int) $_POST['id'];
    $nama   = esc($_POST['nama']);
    $telp   = esc($_POST['telp']);
    $alamat = esc($_POST['alamat']);

    if ($id > 0) {
        mysqli_query($conn, "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id=$id");
    } else {
        mysqli_query($conn, "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama','$telp','$alamat')");
    }
    header('Location: supplier.php');
    exit;
}

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    if (!mysqli_query($conn, "DELETE FROM supplier WHERE id=$id")) {
        $pesan = 'Supplier tidak bisa dihapus karena masih dipakai data barang.';
    }
}

$edit = ['id' => 0, 'nama' => '', 'telp' => '', 'alamat' => ''];
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM supplier WHERE id=$id")) ?: $edit;
}

$data = mysqli_query($conn, "SELECT * FROM supplier ORDER BY id");
include 'header.php';
?>
<h4>Data Supplier</h4>
<?php if ($pesan) { ?><div class="alert alert-danger"><?= $pesan ?></div><?php } ?>

<form method="post" class="card card-body mb-4">
    <input type="hidden" name="id" value="<?= $edit['id'] ?>">
    <div class="row g-2">
        <div class="col-md-4"><input name="nama" class="form-control" placeholder="Nama" value="<?= h($edit['nama']) ?>" required></div>
        <div class="col-md-3"><input name="telp" class="form-control" placeholder="Telp" maxlength="12" value="<?= h($edit['telp']) ?>" required></div>
        <div class="col-md-3"><input name="alamat" class="form-control" placeholder="Alamat" value="<?= h($edit['alamat']) ?>" required></div>
        <div class="col-md-2"><button name="simpan" class="btn btn-success w-100">Simpan</button></div>
    </div>
</form>

<table class="table table-bordered table-striped">
    <tr><th>No</th><th>Nama</th><th>Telp</th><th>Alamat</th><th>Aksi</th></tr>
    <?php $no = 1; while ($d = mysqli_fetch_assoc($data)) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= h($d['nama']) ?></td>
        <td><?= h($d['telp']) ?></td>
        <td><?= h($d['alamat']) ?></td>
        <td>
            <a href="?edit=<?= $d['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="?hapus=<?= $d['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>
<?php include 'footer.php'; ?>
