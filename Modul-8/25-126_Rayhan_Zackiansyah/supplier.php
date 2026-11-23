<?php
include 'koneksi.php';
wajib_login(true);

$pesan = '';

if (isset($_POST['simpan'])) {
  $id = (int) ($_POST['id'] ?? 0);
  $nama = mysqli_real_escape_string($conn, trim($_POST['nama']));
  $telp = mysqli_real_escape_string($conn, trim($_POST['telp']));
  $alamat = mysqli_real_escape_string($conn, trim($_POST['alamat']));

  if ($nama == '') {
    $pesan = 'Nama supplier wajib diisi.';
  } else {
    if ($id > 0) {
      mysqli_query($conn, "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id=$id");
    } else {
      mysqli_query($conn, "INSERT INTO supplier (nama, telp, alamat) VALUES ('$nama', '$telp', '$alamat')");
    }

    header('Location: supplier.php?pesan=tersimpan');
    exit;
  }
}

if (isset($_POST['hapus'])) {
  $id = (int) $_POST['id'];
  $cek = mysqli_query($conn, "SELECT id FROM barang WHERE supplier_id=$id LIMIT 1");

  if (mysqli_num_rows($cek) > 0) {
    header('Location: supplier.php?pesan=digunakan');
  } else {
    mysqli_query($conn, "DELETE FROM supplier WHERE id=$id");
    header('Location: supplier.php?pesan=terhapus');
  }

  exit;
}

$edit = null;

if (isset($_GET['edit'])) {
  $id = (int) $_GET['edit'];
  $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM supplier WHERE id=$id"));
}

$data = mysqli_query($conn, 'SELECT * FROM supplier ORDER BY id');
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <title>Data Supplier</title>
</head>
<body>

<?php menu(); ?>

<h2>Data Supplier</h2>

<?php if (isset($_GET['pesan']) || $pesan != '') { ?>
  <p class="pesan">
    <?= htmlspecialchars($_GET['pesan'] ?? $pesan); ?>
  </p>
<?php } ?>

<form method="post">
  <input type="hidden" name="id" value="<?= $edit['id'] ?? 0; ?>">

  Nama:
  <input name="nama" value="<?= htmlspecialchars($edit['nama'] ?? ''); ?>" required>
  <br><br>

  Telepon:
  <input name="telp" maxlength="12" value="<?= htmlspecialchars($edit['telp'] ?? ''); ?>">
  <br><br>

  Alamat:
  <input name="alamat" value="<?= htmlspecialchars($edit['alamat'] ?? ''); ?>">
  <br><br>

  <button name="simpan">Simpan</button>
  <a href="supplier.php">Batal</a>
</form>

<h3>Daftar Supplier</h3>

<table border="1" cellpadding="6">
  <tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Telepon</th>
    <th>Alamat</th>
    <th>Aksi</th>
  </tr>

  <?php while ($s = mysqli_fetch_assoc($data)) { ?>
    <tr>
      <td><?= $s['id']; ?></td>
      <td><?= htmlspecialchars($s['nama']); ?></td>
      <td><?= htmlspecialchars($s['telp']); ?></td>
      <td><?= htmlspecialchars($s['alamat']); ?></td>
      <td>
        <a href="supplier.php?edit=<?= $s['id']; ?>">Edit</a>

        <form method="post" style="display:inline" onsubmit="return confirm('Hapus supplier?')">
          <input type="hidden" name="id" value="<?= $s['id']; ?>">
          <button name="hapus">Hapus</button>
        </form>
      </td>
    </tr>
  <?php } ?>
</table>

</body>
</html>
