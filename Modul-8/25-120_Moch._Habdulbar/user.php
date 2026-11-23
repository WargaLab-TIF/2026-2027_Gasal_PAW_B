<?php
require 'config.php';
wajib_level(1);
$aksi  = $_GET['aksi'] ?? '';
$pesan = '';
$row   = ['id_user' => 0, 'username' => '', 'nama' => '', 'alamat' => '', 'hp' => '', 'level' => 2];
$label = [1 => 'Owner', 2 => 'Kasir', 3 => 'Gudang'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['hapus'])) {
        if ($_POST['hapus'] == $_SESSION['id_user']) {
            $pesan = 'Anda tidak dapat menghapus akun yang sedang dipakai login.';
        } else {
            $s = mysqli_prepare($conn, "DELETE FROM user WHERE id_user=?");
            mysqli_stmt_bind_param($s, 'i', $_POST['hapus']);
            mysqli_stmt_execute($s);
            flash('Data user berhasil dihapus.');
            header('Location: user.php'); exit;
        }
    } else {
        $id = (int)$_POST['id_user'];
        $username = trim($_POST['username']); $password = $_POST['password'];
        $nama = trim($_POST['nama']); $alamat = trim($_POST['alamat']); $hp = trim($_POST['hp']);
        $level = (int)$_POST['level'];
        $row = ['id_user' => $id, 'username' => $username, 'nama' => $nama, 'alamat' => $alamat, 'hp' => $hp, 'level' => $level];
        $aksi = $id ? 'edit' : 'tambah';
        if ($username === '' || $nama === '') {
            $pesan = 'Username dan nama wajib diisi.';
        } elseif (!$id && $password === '') {
            $pesan = 'Password wajib diisi untuk user baru.';
        } elseif (!isset($label[$level])) {
            $pesan = 'Level tidak valid.';
        } else {
            try {
                if ($id) {
                    if ($password === '') {
                        $s = mysqli_prepare($conn, "UPDATE user SET username=?, nama=?, alamat=?, hp=?, level=? WHERE id_user=?");
                        mysqli_stmt_bind_param($s, 'ssssii', $username, $nama, $alamat, $hp, $level, $id);
                    } else {
                        $s = mysqli_prepare($conn, "UPDATE user SET username=?, nama=?, alamat=?, hp=?, level=?, password=MD5(?) WHERE id_user=?");
                        mysqli_stmt_bind_param($s, 'ssssisi', $username, $nama, $alamat, $hp, $level, $password, $id);
                    }
                } else {
                    $s = mysqli_prepare($conn, "INSERT INTO user (username, password, nama, alamat, hp, level) VALUES (?, MD5(?), ?, ?, ?, ?)");
                    mysqli_stmt_bind_param($s, 'sssssi', $username, $password, $nama, $alamat, $hp, $level);
                }
                mysqli_stmt_execute($s);
                // jika user yang sedang login mengubah namanya sendiri
                if ($id == $_SESSION['id_user']) { $_SESSION['nama'] = $nama; $_SESSION['level'] = $level; }
                flash('Data user berhasil disimpan.');
                header('Location: user.php'); exit;
            } catch (mysqli_sql_exception $e) {
                $pesan = 'Gagal menyimpan. Username sudah dipakai atau data terlalu panjang.';
            }
        }
    }
}
if ($aksi == 'edit' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $s = mysqli_prepare($conn, "SELECT * FROM user WHERE id_user=?");
    mysqli_stmt_bind_param($s, 'i', $_GET['id']);
    mysqli_stmt_execute($s);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($s)) ?: $row;
}
include 'header.php';
?>
<h3>Data User</h3>
<?php if ($pesan) { ?><div class="alert alert-danger"><?= h($pesan) ?></div><?php } ?>

<?php if ($aksi == 'tambah' || $aksi == 'edit') { ?>
<form method="post" class="form-horizontal" style="max-width:600px">
  <input type="hidden" name="id_user" value="<?= (int)$row['id_user'] ?>">
  <div class="form-group"><label class="col-sm-3 control-label">Username</label>
    <div class="col-sm-9"><input type="text" name="username" class="form-control" maxlength="30" value="<?= h($row['username']) ?>"></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Password</label>
    <div class="col-sm-9"><input type="password" name="password" class="form-control">
      <?php if ($aksi == 'edit') { ?><span class="help-block">Kosongkan jika tidak ingin mengubah password.</span><?php } ?></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Nama</label>
    <div class="col-sm-9"><input type="text" name="nama" class="form-control" maxlength="50" value="<?= h($row['nama']) ?>"></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Alamat</label>
    <div class="col-sm-9"><input type="text" name="alamat" class="form-control" maxlength="150" value="<?= h($row['alamat']) ?>"></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">HP</label>
    <div class="col-sm-9"><input type="text" name="hp" class="form-control" maxlength="20" value="<?= h($row['hp']) ?>"></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Level</label>
    <div class="col-sm-9">
      <select name="level" class="form-control">
        <?php foreach ($label as $k => $v) { ?>
        <option value="<?= $k ?>" <?= $row['level'] == $k ? 'selected' : '' ?>><?= $k ?> - <?= $v ?></option>
        <?php } ?>
      </select>
    </div></div>
  <div class="form-group"><div class="col-sm-offset-3 col-sm-9">
    <button class="btn btn-primary">Simpan</button> <a href="user.php" class="btn btn-default">Batal</a></div></div>
</form>
<?php } else { ?>
<a href="?aksi=tambah" class="btn btn-primary" style="margin-bottom:10px">Tambah User</a>
<table class="table table-bordered table-striped">
  <tr><th>No</th><th>Username</th><th>Nama</th><th>Alamat</th><th>HP</th><th>Level</th><th width="140">Aksi</th></tr>
  <?php $no = 1; $q = mysqli_query($conn, "SELECT * FROM user ORDER BY id_user");
  while ($r = mysqli_fetch_assoc($q)) { ?>
  <tr>
    <td><?= $no++ ?></td><td><?= h($r['username']) ?></td><td><?= h($r['nama']) ?></td>
    <td><?= h($r['alamat']) ?></td><td><?= h($r['hp']) ?></td><td><?= $label[$r['level']] ?? $r['level'] ?></td>
    <td>
      <a href="?aksi=edit&id=<?= $r['id_user'] ?>" class="btn btn-xs btn-warning">Edit</a>
      <form method="post" style="display:inline" onsubmit="return confirm('Hapus data ini?')">
        <input type="hidden" name="hapus" value="<?= $r['id_user'] ?>"><button class="btn btn-xs btn-danger">Hapus</button>
      </form>
    </td>
  </tr>
  <?php } ?>
</table>
<?php } ?>
<?php include 'footer.php'; ?>
