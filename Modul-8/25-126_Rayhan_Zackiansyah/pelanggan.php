
<?php
include 'koneksi.php';
wajib_login(true);

$pesan = '';

if (isset($_POST['simpan'])) {
  $id_lama = mysqli_real_escape_string($conn, $_POST['id_lama'] ?? '');
  $id = mysqli_real_escape_string($conn, trim($_POST['id']));
  $nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
  $jenis = $_POST['jenis_kelamin'] == 'P' ? 'P' : 'L';
  $telp = mysqli_real_escape_string($conn, trim($_POST['telp']));
  $alamat = mysqli_real_escape_string($conn, trim($_POST['alamat']));

  if ($id == '' || $nama == '') {
    $pesan = 'ID dan nama pelanggan wajib diisi.';
  } else {
    if ($id_lama != '') {
      mysqli_query($conn, "UPDATE pelanggan SET nama='$nama', jenis_kelamin='$jenis', telp='$telp', alamat='$alamat' WHERE id='$id_lama'");
    } else {
      $cek = mysqli_query($conn, "SELECT id FROM pelanggan WHERE id='$id'");

      if (mysqli_num_rows($cek) > 0) {
        $pesan = 'ID pelanggan sudah ada.';
      } else {
        mysqli_query($conn, "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES ('$id', '$nama', '$jenis', '$telp', '$alamat')");
      }
    }

    if ($pesan == '') {
      header('Location: pelanggan.php?pesan=tersimpan');
      exit;
    }
  }
}

if (isset($_POST['hapus'])) {
  $id = mysqli_real_escape_string($conn, $_POST['id']);
  $cek = mysqli_query($conn, "SELECT id FROM transaksi WHERE pelanggan_id='$id' LIMIT 1");

  if (mysqli_num_rows($cek) > 0) {
    header('Location: pelanggan.php?pesan=digunakan');
  } else {
    mysqli_query($conn, "DELETE FROM pelanggan WHERE id='$id'");
    header('Location: pelanggan.php?pesan=terhapus');
  }

  exit;
}

$edit = null;

if (isset($_GET['edit'])) {
  $id = mysqli_real_escape_string($conn, $_GET['edit']);
  $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM pelanggan WHERE id='$id'"));
}

$data = mysqli_query($conn, 'SELECT * FROM pelanggan ORDER BY id');
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <title>Data Pelanggan</title>
</head>
<body>

<?php menu(); ?>

<h2>Data Pelanggan</h2>

<?php if (isset($_GET['pesan']) || $pesan != '') { ?>
  <p class="pesan">
    <?= htmlspecialchars($_GET['pesan'] ?? $pesan); ?>
  </p>
<?php } ?>

<form method="post">
  <input type="hidden" name="id_lama" value="<?= htmlspecialchars($edit['id'] ?? ''); ?>">

  ID:
  <input name="id" maxlength="20" value="<?= htmlspecialchars($edit['id'] ?? ''); ?>" <?= $edit ? 'readonly' : ''; ?> required>
  <br><br>

  Nama:
  <input name="nama" value="<?= htmlspecialchars($edit['nama'] ?? ''); ?>" required>
  <br><br>

  Jenis Kelamin:
  <select name="jenis_kelamin">
    <option value="L" <?= ($edit['jenis_kelamin'] ?? 'L') == 'L' ? 'selected' : ''; ?>>L</option>
    <option value="P" <?= ($edit['jenis_kelamin'] ?? '') == 'P' ? 'selected' : ''; ?>>P</option>
  </select>
  <br><br>

  Telepon:
  <input name="telp" maxlength="12" value="<?= htmlspecialchars($edit['telp'] ?? ''); ?>">
  <br><br>

  Alamat:
  <input name="alamat" value="<?= htmlspecialchars($edit['alamat'] ?? ''); ?>">
  <br><br>

  <button name="simpan">Simpan</button>
  <a href="pelanggan.php">Batal</a>
</form>

<h3>Daftar Pelanggan</h3>

<table border="1" cellpadding="6">
  <tr>
    <th>ID</th>
    <th>Nama</th>
    <th>JK</th>
    <th>Telepon</th>
    <th>Alamat</th>
    <th>Aksi</th>
  </tr>

  <?php while ($p = mysqli_fetch_assoc($data)) { ?>
    <tr>
      <td><?= htmlspecialchars($p['id']); ?></td>
      <td><?= htmlspecialchars($p['nama']); ?></td>
      <td><?= $p['jenis_kelamin']; ?></td>
      <td><?= htmlspecialchars($p['telp']); ?></td>
      <td><?= htmlspecialchars($p['alamat']); ?></td>
      <td>
        <a href="pelanggan.php?edit=<?= urlencode($p['id']); ?>">Edit</a>

        <form method="post" style="display:inline" onsubmit="return confirm('Hapus pelanggan?')">
          <input type="hidden" name="id" value="<?= htmlspecialchars($p['id']); ?>">
          <button name="hapus">Hapus</button>
        </form>
      </td>
    </tr>
  <?php } ?>
</table>

</body>
</html>