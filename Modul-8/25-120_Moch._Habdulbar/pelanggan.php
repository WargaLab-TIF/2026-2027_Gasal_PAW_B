<?php
require 'config.php';
wajib_level(1);
$aksi  = $_GET['aksi'] ?? '';
$pesan = '';
$row   = ['id' => '', 'nama' => '', 'jenis_kelamin' => 'L', 'telp' => '', 'alamat' => ''];
$edit  = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['hapus'])) {
        try {
            $s = mysqli_prepare($conn, "DELETE FROM pelanggan WHERE id=?");
            mysqli_stmt_bind_param($s, 's', $_POST['hapus']);
            mysqli_stmt_execute($s);
            flash('Data pelanggan berhasil dihapus.');
            header('Location: pelanggan.php'); exit;
        } catch (mysqli_sql_exception $e) {
            $pesan = 'Pelanggan tidak dapat dihapus karena sudah memiliki transaksi.';
        }
    } else {
        $edit = $_POST['edit'] == '1';
        $id = trim($_POST['id']); $nama = trim($_POST['nama']); $jk = $_POST['jenis_kelamin'];
        $telp = trim($_POST['telp']); $alamat = trim($_POST['alamat']);
        $row = ['id' => $id, 'nama' => $nama, 'jenis_kelamin' => $jk, 'telp' => $telp, 'alamat' => $alamat];
        $aksi = $edit ? 'edit' : 'tambah';
        if ($id === '' || $nama === '') {
            $pesan = 'ID dan nama pelanggan wajib diisi.';
        } elseif (!in_array($jk, ['L', 'P'])) {
            $pesan = 'Jenis kelamin tidak valid.';
        } else {
            try {
                if ($edit) {
                    $s = mysqli_prepare($conn, "UPDATE pelanggan SET nama=?, jenis_kelamin=?, telp=?, alamat=? WHERE id=?");
                    mysqli_stmt_bind_param($s, 'sssss', $nama, $jk, $telp, $alamat, $id);
                } else {
                    $s = mysqli_prepare($conn, "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES (?,?,?,?,?)");
                    mysqli_stmt_bind_param($s, 'sssss', $id, $nama, $jk, $telp, $alamat);
                }
                mysqli_stmt_execute($s);
                flash('Data pelanggan berhasil disimpan.');
                header('Location: pelanggan.php'); exit;
            } catch (mysqli_sql_exception $e) {
                $pesan = 'Gagal menyimpan. ID pelanggan sudah dipakai atau data terlalu panjang.';
            }
        }
    }
}
if ($aksi == 'edit' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $s = mysqli_prepare($conn, "SELECT * FROM pelanggan WHERE id=?");
    mysqli_stmt_bind_param($s, 's', $_GET['id']);
    mysqli_stmt_execute($s);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($s)) ?: $row;
}
$edit = ($aksi == 'edit');
include 'header.php';
?>
<h3>Data Pelanggan</h3>
<?php if ($pesan) { ?><div class="alert alert-danger"><?= h($pesan) ?></div><?php } ?>

<?php if ($aksi == 'tambah' || $aksi == 'edit') { ?>
<form method="post" class="form-horizontal" style="max-width:600px">
  <input type="hidden" name="edit" value="<?= $edit ? 1 : 0 ?>">
  <div class="form-group"><label class="col-sm-3 control-label">ID</label>
    <div class="col-sm-9"><input type="text" name="id" class="form-control" maxlength="20" value="<?= h($row['id']) ?>" <?= $edit ? 'readonly' : '' ?>></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Nama</label>
    <div class="col-sm-9"><input type="text" name="nama" class="form-control" maxlength="100" value="<?= h($row['nama']) ?>"></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Jenis Kelamin</label>
    <div class="col-sm-9">
      <label class="radio-inline"><input type="radio" name="jenis_kelamin" value="L" <?= $row['jenis_kelamin'] == 'L' ? 'checked' : '' ?>> Laki-laki</label>
      <label class="radio-inline"><input type="radio" name="jenis_kelamin" value="P" <?= $row['jenis_kelamin'] == 'P' ? 'checked' : '' ?>> Perempuan</label>
    </div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Telp</label>
    <div class="col-sm-9"><input type="text" name="telp" class="form-control" maxlength="12" value="<?= h($row['telp']) ?>"></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Alamat</label>
    <div class="col-sm-9"><textarea name="alamat" class="form-control"><?= h($row['alamat']) ?></textarea></div></div>
  <div class="form-group"><div class="col-sm-offset-3 col-sm-9">
    <button class="btn btn-primary">Simpan</button> <a href="pelanggan.php" class="btn btn-default">Batal</a></div></div>
</form>
<?php } else { ?>
<a href="?aksi=tambah" class="btn btn-primary" style="margin-bottom:10px">Tambah Pelanggan</a>
<table class="table table-bordered table-striped">
  <tr><th>ID</th><th>Nama</th><th>JK</th><th>Telp</th><th>Alamat</th><th width="140">Aksi</th></tr>
  <?php $q = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY id");
  while ($r = mysqli_fetch_assoc($q)) { ?>
  <tr>
    <td><?= h($r['id']) ?></td><td><?= h($r['nama']) ?></td><td><?= h($r['jenis_kelamin']) ?></td><td><?= h($r['telp']) ?></td><td><?= h($r['alamat']) ?></td>
    <td>
      <a href="?aksi=edit&id=<?= urlencode($r['id']) ?>" class="btn btn-xs btn-warning">Edit</a>
      <form method="post" style="display:inline" onsubmit="return confirm('Hapus data ini?')">
        <input type="hidden" name="hapus" value="<?= h($r['id']) ?>"><button class="btn btn-xs btn-danger">Hapus</button>
      </form>
    </td>
  </tr>
  <?php } ?>
</table>
<?php } ?>
<?php include 'footer.php'; ?>
