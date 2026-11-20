<?php
include 'koneksi.php';
$owner_only = true;
include 'cek.php';

$pesan = '';
if (isset($_POST['simpan'])) {
    $id     = esc($_POST['id']);
    $nama   = esc($_POST['nama']);
    $jk     = esc($_POST['jenis_kelamin']);
    $telp   = esc($_POST['telp']);
    $alamat = esc($_POST['alamat']);

    if ($_POST['mode'] == 'edit') {
        mysqli_query($conn, "UPDATE pelanggan SET nama='$nama', jenis_kelamin='$jk', telp='$telp', alamat='$alamat' WHERE id='$id'");
    } else {
        $ok = mysqli_query($conn, "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES ('$id','$nama','$jk','$telp','$alamat')");
        if (!$ok) {
            $pesan = 'ID pelanggan sudah dipakai.';
        }
    }
    if ($pesan == '') {
        header('Location: pelanggan.php');
        exit;
    }
}

if (isset($_GET['hapus'])) {
    $id = esc($_GET['hapus']);
    if (!mysqli_query($conn, "DELETE FROM pelanggan WHERE id='$id'")) {
        $pesan = 'Pelanggan tidak bisa dihapus karena sudah punya transaksi.';
    }
}

$mode = 'tambah';
$edit = ['id' => '', 'nama' => '', 'jenis_kelamin' => 'L', 'telp' => '', 'alamat' => ''];
if (isset($_GET['edit'])) {
    $id = esc($_GET['edit']);
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pelanggan WHERE id='$id'"));
    if ($row) {
        $edit = $row;
        $mode = 'edit';
    }
}

$data = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY id");
include 'header.php';
?>
<h4>Data Pelanggan</h4>
<?php if ($pesan) { ?><div class="alert alert-danger"><?= $pesan ?></div><?php } ?>

<form method="post" class="card card-body mb-4">
    <input type="hidden" name="mode" value="<?= $mode ?>">
    <div class="row g-2">
        <div class="col-md-2"><input name="id" class="form-control" placeholder="ID (PLG007)" maxlength="20" value="<?= h($edit['id']) ?>" <?= $mode == 'edit' ? 'readonly' : '' ?> required></div>
        <div class="col-md-3"><input name="nama" class="form-control" placeholder="Nama" value="<?= h($edit['nama']) ?>" required></div>
        <div class="col-md-2">
            <select name="jenis_kelamin" class="form-select">
                <option value="L" <?= $edit['jenis_kelamin'] == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                <option value="P" <?= $edit['jenis_kelamin'] == 'P' ? 'selected' : '' ?>>Perempuan</option>
            </select>
        </div>
        <div class="col-md-2"><input name="telp" class="form-control" placeholder="Telp" maxlength="12" value="<?= h($edit['telp']) ?>" required></div>
        <div class="col-md-2"><input name="alamat" class="form-control" placeholder="Alamat" value="<?= h($edit['alamat']) ?>" required></div>
        <div class="col-md-1"><button name="simpan" class="btn btn-success w-100">Simpan</button></div>
    </div>
</form>

<table class="table table-bordered table-striped">
    <tr><th>ID</th><th>Nama</th><th>JK</th><th>Telp</th><th>Alamat</th><th>Aksi</th></tr>
    <?php while ($d = mysqli_fetch_assoc($data)) { ?>
    <tr>
        <td><?= h($d['id']) ?></td>
        <td><?= h($d['nama']) ?></td>
        <td><?= $d['jenis_kelamin'] ?></td>
        <td><?= h($d['telp']) ?></td>
        <td><?= h($d['alamat']) ?></td>
        <td>
            <a href="?edit=<?= h($d['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="?hapus=<?= h($d['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>
<?php include 'footer.php'; ?>
