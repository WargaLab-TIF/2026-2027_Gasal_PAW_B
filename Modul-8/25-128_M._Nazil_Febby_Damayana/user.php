<?php
include 'koneksi.php';
$owner_only = true;
include 'cek.php';

$pesan = '';

if (isset($_POST['simpan'])) {
    $id       = (int) $_POST['id_user'];
    $username = esc($_POST['username']);
    $password = esc($_POST['password']);
    $nama     = esc($_POST['nama']);
    $alamat   = esc($_POST['alamat']);
    $hp       = esc($_POST['hp']);
    $level    = (int) $_POST['level'];

    $cek = mysqli_query($conn, "SELECT id_user FROM user WHERE username='$username' AND id_user<>$id");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = 'Username sudah dipakai.';
    } elseif ($id > 0) {
        $sql = "UPDATE user SET username='$username', nama='$nama', alamat='$alamat', hp='$hp', level=$level";
        if ($password != '') {
            $sql .= ", password='$password'";
        }
        mysqli_query($conn, $sql . " WHERE id_user=$id");
    } else {
        mysqli_query($conn, "INSERT INTO user (username, password, nama, alamat, hp, level) VALUES ('$username','$password','$nama','$alamat','$hp',$level)");
    }
    if ($pesan == '') {
        header('Location: user.php');
        exit;
    }
}

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    if ($id == $_SESSION['id_user']) {
        $pesan = 'Akun yang sedang dipakai tidak bisa dihapus.';
    } else {
        mysqli_query($conn, "DELETE FROM user WHERE id_user=$id");
    }
}

$edit = ['id_user' => 0, 'username' => '', 'nama' => '', 'alamat' => '', 'hp' => '', 'level' => 2];
if (isset($_GET['edit'])) {
    $id = (int) $_GET['edit'];
    $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user=$id")) ?: $edit;
}

$data = mysqli_query($conn, "SELECT * FROM user ORDER BY id_user");
include 'header.php';
?>
<h4>Data User</h4>
<?php if ($pesan) { ?><div class="alert alert-danger"><?= $pesan ?></div><?php } ?>

<form method="post" class="card card-body mb-4" autocomplete="off">
    <input type="hidden" name="id_user" value="<?= $edit['id_user'] ?>">
    <div class="row g-2">
        <div class="col-md-3"><input name="username" class="form-control" placeholder="Username" maxlength="30" value="<?= h($edit['username']) ?>" required></div>
        <div class="col-md-3"><input type="password" name="password" class="form-control" placeholder="<?= $edit['id_user'] ? 'Password (kosongkan jika tidak diubah)' : 'Password' ?>" <?= $edit['id_user'] ? '' : 'required' ?>></div>
        <div class="col-md-3"><input name="nama" class="form-control" placeholder="Nama" value="<?= h($edit['nama']) ?>" required></div>
        <div class="col-md-3">
            <select name="level" class="form-select">
                <option value="1" <?= $edit['level'] == 1 ? 'selected' : '' ?>>1 - Owner</option>
                <option value="2" <?= $edit['level'] == 2 ? 'selected' : '' ?>>2 - Kasir</option>
            </select>
        </div>
        <div class="col-md-5"><input name="alamat" class="form-control" placeholder="Alamat" value="<?= h($edit['alamat']) ?>"></div>
        <div class="col-md-4"><input name="hp" class="form-control" placeholder="HP" maxlength="20" value="<?= h($edit['hp']) ?>" required></div>
        <div class="col-md-3"><button name="simpan" class="btn btn-success w-100">Simpan</button></div>
    </div>
</form>

<table class="table table-bordered table-striped">
    <tr><th>No</th><th>Username</th><th>Nama</th><th>Alamat</th><th>HP</th><th>Level</th><th>Aksi</th></tr>
    <?php $no = 1; while ($d = mysqli_fetch_assoc($data)) { ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= h($d['username']) ?></td>
        <td><?= h($d['nama']) ?></td>
        <td><?= h($d['alamat']) ?></td>
        <td><?= h($d['hp']) ?></td>
        <td><?= $d['level'] == 1 ? 'Owner' : 'Kasir' ?></td>
        <td>
            <a href="?edit=<?= $d['id_user'] ?>" class="btn btn-warning btn-sm">Edit</a>
            <a href="?hapus=<?= $d['id_user'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>
<?php include 'footer.php'; ?>
