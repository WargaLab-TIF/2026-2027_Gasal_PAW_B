<?php
require 'config.php';
wajib_level(1);
$aksi  = $_GET['aksi'] ?? '';
$pesan = '';
$row   = ['id' => 0, 'nama' => '', 'telp' => '', 'alamat' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['hapus'])) {
        try {
            $s = mysqli_prepare($conn, "DELETE FROM supplier WHERE id=?");
            mysqli_stmt_bind_param($s, 'i', $_POST['hapus']);
            mysqli_stmt_execute($s);
            flash('Data supplier berhasil dihapus.');
            header('Location: supplier.php'); exit;
        } catch (mysqli_sql_exception $e) {
            $pesan = 'Supplier tidak dapat dihapus karena masih dipakai oleh data barang.';
        }
    } else {
        $id = (int)$_POST['id'];
        $nama = trim($_POST['nama']); $telp = trim($_POST['telp']); $alamat = trim($_POST['alamat']);
        $row = ['id' => $id, 'nama' => $nama, 'telp' => $telp, 'alamat' => $alamat];
        $aksi = $id ? 'edit' : 'tambah';
        if ($nama === '') {
            $pesan = 'Nama supplier wajib diisi.';
        } elseif (strlen($telp) > 12) {
            $pesan = 'No. telp maksimal 12 karakter.';
        } else {
            if ($id) {
                $s = mysqli_prepare($conn, "UPDATE supplier SET nama=?, telp=?, alamat=? WHERE id=?");
                mysqli_stmt_bind_param($s, 'sssi', $nama, $telp, $alamat, $id);
            } else {
                $s = mysqli_prepare($conn, "INSERT INTO supplier (nama, telp, alamat) VALUES (?,?,?)");
                mysqli_stmt_bind_param($s, 'sss', $nama, $telp, $alamat);
            }
            mysqli_stmt_execute($s);
            flash('Data supplier berhasil disimpan.');
            header('Location: supplier.php'); exit;
        }
    }
}
if ($aksi == 'edit' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $s = mysqli_prepare($conn, "SELECT * FROM supplier WHERE id=?");
    mysqli_stmt_bind_param($s, 'i', $_GET['id']);
    mysqli_stmt_execute($s);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($s)) ?: $row;
}
include 'header.php';
?>
<h3>Data Supplier</h3>
<?php if ($pesan) { ?><div class="alert alert-danger"><?= h($pesan) ?></div><?php } ?>

<?php if ($aksi == 'tambah' || $aksi == 'edit') { ?>
<form method="post" class="form-horizontal" style="max-width:600px">
  <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
  <div class="form-group"><label class="col-sm-3 control-label">Nama</label>
    <div class="col-sm-9"><input type="text" name="nama" class="form-control" maxlength="100" value="<?= h($row['nama']) ?>"></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Telp</label>
    <div class="col-sm-9"><input type="text" name="telp" class="form-control" maxlength="12" value="<?= h($row['telp']) ?>"></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Alamat</label>
    <div class="col-sm-9"><textarea name="alamat" class="form-control"><?= h($row['alamat']) ?></textarea></div></div>
  <div class="form-group"><div class="col-sm-offset-3 col-sm-9">
    <button class="btn btn-primary">Simpan</button> <a href="supplier.php" class="btn btn-default">Batal</a></div></div>
</form>
<?php } else { ?>
<a href="?aksi=tambah" class="btn btn-primary" style="margin-bottom:10px">Tambah Supplier</a>
<table class="table table-bordered table-striped">
  <tr><th>No</th><th>Nama</th><th>Telp</th><th>Alamat</th><th width="140">Aksi</th></tr>
  <?php $no = 1; $q = mysqli_query($conn, "SELECT * FROM supplier ORDER BY id");
  while ($r = mysqli_fetch_assoc($q)) { ?>
  <tr>
    <td><?= $no++ ?></td><td><?= h($r['nama']) ?></td><td><?= h($r['telp']) ?></td><td><?= h($r['alamat']) ?></td>
    <td>
      <a href="?aksi=edit&id=<?= $r['id'] ?>" class="btn btn-xs btn-warning">Edit</a>
      <form method="post" style="display:inline" onsubmit="return confirm('Hapus data ini?')">
        <input type="hidden" name="hapus" value="<?= $r['id'] ?>"><button class="btn btn-xs btn-danger">Hapus</button>
      </form>
    </td>
  </tr>
  <?php } ?>
</table>
<?php } ?>
<?php include 'footer.php'; ?>
