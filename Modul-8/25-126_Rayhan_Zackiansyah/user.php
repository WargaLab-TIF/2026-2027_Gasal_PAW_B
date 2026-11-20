
<?php
include 'koneksi.php';
wajib_login(true);

$pesan = '';

if (isset($_POST['simpan'])) {
  $id = (int) ($_POST['id_user'] ?? 0);
  $username = mysqli_real_escape_string($conn, trim($_POST['username']));
  $nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
  $alamat = mysqli_real_escape_string($conn, trim($_POST['alamat']));
  $hp = mysqli_real_escape_string($conn, trim($_POST['hp']));
  $level = (int) $_POST['level'];
  $password = $_POST['password'];

  $cek = mysqli_query($conn, "SELECT id_user FROM user WHERE username='$username' AND id_user!=$id");

  if ($username == '' || $nama == '' || !in_array($level, [1, 2])) {
    $pesan = 'Username, nama, dan level wajib diisi dengan benar.';
  } elseif (mysqli_num_rows($cek) > 0) {
    $pesan = 'Username sudah dipakai.';
  } elseif ($id == $_SESSION['id_user'] && $level != 1) {
    $pesan = 'Tidak boleh mengubah level akun sendiri.';
  } elseif ($password != '' && strlen($password) < 6) {
    $pesan = 'Password minimal 6 karakter.';
  } elseif ($id == 0 && $password == '') {
    $pesan = 'Password untuk user baru wajib diisi.';
  } else {
    if ($id > 0) {
      mysqli_query($conn, "UPDATE user SET username='$username', nama='$nama', alamat='$alamat', hp='$hp', level=$level WHERE id_user=$id");

      if ($password != '') {
        $hash = mysqli_real_escape_string($conn, password_hash($password, PASSWORD_DEFAULT));
        mysqli_query($conn, "UPDATE user SET password='$hash' WHERE id_user=$id");
      }

      if ($id == $_SESSION['id_user']) {
        $_SESSION['nama'] = $_POST['nama'];
        $_SESSION['username'] = $_POST['username'];
      }
    } else {
      $hash = mysqli_real_escape_string($conn, password_hash($password, PASSWORD_DEFAULT));

      mysqli_query($conn, "INSERT INTO user (username, password, nama, alamat, hp, level) VALUES ('$username', '$hash', '$nama', '$alamat', '$hp', $level)");
    }

    header('Location: user.php?pesan=tersimpan');
    exit;
  }
}

if (isset($_POST['hapus'])) {
  $id = (int) $_POST['id_user'];

  if ($id == $_SESSION['id_user']) {
    header('Location: user.php?pesan=tidak_bisa_hapus_akun_sendiri');
  } else {
    mysqli_query($conn, "DELETE FROM user WHERE id_user=$id");
    header('Location: user.php?pesan=terhapus');
  }

  exit;
}

$edit = null;

if (isset($_GET['edit'])) {
  $id = (int) $_GET['edit'];
  $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id_user=$id"));
}

$data = mysqli_query($conn, 'SELECT * FROM user ORDER BY id_user');
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <title>Data User</title>
</head>
<body>

<?php menu(); ?>

<h2>Data User</h2>

<?php if (isset($_GET['pesan']) || $pesan != '') { ?>
  <p class="pesan">
    <?= htmlspecialchars($_GET['pesan'] ?? $pesan); ?>
  </p>
<?php } ?>

<form method="post">
  <input type="hidden" name="id_user" value="<?= $edit['id_user'] ?? 0; ?>">

  Username:
  <input name="username" maxlength="30" value="<?= htmlspecialchars($edit['username'] ?? ''); ?>" required>
  <br><br>

  Password:
  <input type="password" name="password" <?= $edit ? '' : 'required'; ?> placeholder="<?= $edit ? 'Kosongkan jika tidak diubah' : 'Password'; ?>">
  <br><br>

  Nama:
  <input name="nama" maxlength="50" value="<?= htmlspecialchars($edit['nama'] ?? ''); ?>" required>
  <br><br>

  Alamat:
  <input name="alamat" value="<?= htmlspecialchars($edit['alamat'] ?? ''); ?>">
  <br><br>

  HP:
  <input name="hp" maxlength="20" value="<?= htmlspecialchars($edit['hp'] ?? ''); ?>">
  <br><br>

  Level:
  <select name="level">
    <option value="1" <?= ($edit['level'] ?? 2) == 1 ? 'selected' : ''; ?>>1 - Owner</option>
    <option value="2" <?= ($edit['level'] ?? 2) == 2 ? 'selected' : ''; ?>>2 - Kasir</option>
  </select>
  <br><br>

  <button name="simpan">Simpan</button>
  <a href="user.php">Batal</a>
</form>

<h3>Daftar User</h3>

<table border="1" cellpadding="6">
  <tr>
    <th>ID</th>
    <th>Username</th>
    <th>Nama</th>
    <th>Alamat</th>
    <th>HP</th>
    <th>Level</th>
    <th>Aksi</th>
  </tr>

  <?php while ($u = mysqli_fetch_assoc($data)) { ?>
    <tr>
      <td><?= $u['id_user']; ?></td>
      <td><?= htmlspecialchars($u['username']); ?></td>
      <td><?= htmlspecialchars($u['nama']); ?></td>
      <td><?= htmlspecialchars($u['alamat']); ?></td>
      <td><?= htmlspecialchars($u['hp']); ?></td>
      <td><?= $u['level'] == 1 ? 'Owner' : 'Kasir'; ?></td>
      <td>
        <a href="user.php?edit=<?= $u['id_user']; ?>">Edit</a>

        <form method="post" style="display:inline" onsubmit="return confirm('Hapus user?')">
          <input type="hidden" name="id_user" value="<?= $u['id_user']; ?>">
          <button name="hapus">Hapus</button>
        </form>
      </td>
    </tr>
  <?php } ?>
</table>

</body>
</html>