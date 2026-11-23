<?php
include 'koneksi.php';
wajib_login(true);

$pesan = '';

if (isset($_POST['simpan'])) {
  $id = (int) ($_POST['id'] ?? 0);
  $kode = mysqli_real_escape_string($conn, trim($_POST['kode_barang']));
  $nama = mysqli_real_escape_string($conn, trim($_POST['nama_barang']));
  $harga = (int) $_POST['harga'];
  $stok = (int) $_POST['stok'];
  $supplier_id = (int) $_POST['supplier_id'];

  if ($kode == '' || $nama == '' || $harga < 0 || $stok < 0 || $supplier_id < 1) {
    $pesan = 'Isi data barang dengan benar.';
  } else {
    if ($id > 0) {
      mysqli_query($conn, "UPDATE barang SET kode_barang='$kode', nama_barang='$nama', harga=$harga, stok=$stok, supplier_id=$supplier_id WHERE id=$id");
    } else {
      mysqli_query($conn, "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES ('$kode', '$nama', $harga, $stok, $supplier_id)");
    }

    header('Location: barang.php?pesan=tersimpan');
    exit;
  }
}

if (isset($_POST['hapus'])) {
  $id = (int) $_POST['id'];
  $cek = mysqli_query($conn, "SELECT barang_id FROM transaksi_detail WHERE barang_id=$id LIMIT 1");

  if (mysqli_num_rows($cek) > 0) {
    header('Location: barang.php?pesan=digunakan');
  } else {
    mysqli_query($conn, "DELETE FROM barang WHERE id=$id");
    header('Location: barang.php?pesan=terhapus');
  }

  exit;
}

$edit = null;

if (isset($_GET['edit'])) {
  $id = (int) $_GET['edit'];
  $edit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE id=$id"));
}

$data_supplier = mysqli_query($conn, 'SELECT * FROM supplier ORDER BY nama');

$data = mysqli_query($conn, 'SELECT barang.*, supplier.nama AS nama_supplier FROM barang INNER JOIN supplier ON barang.supplier_id=supplier.id ORDER BY barang.id');
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <title>Data Barang</title>
</head>
<body>

<?php menu(); ?>

<h2>Data Barang</h2>

<?php if (isset($_GET['pesan']) || $pesan != '') { ?>
  <p class="pesan">
    <?= htmlspecialchars($_GET['pesan'] ?? $pesan); ?>
  </p>
<?php } ?>

<h3><?= $edit ? 'Edit' : 'Tambah'; ?> Barang</h3>

<form method="post">
  <input type="hidden" name="id" value="<?= $edit['id'] ?? 0; ?>">

  Kode:
  <input name="kode_barang" maxlength="10" value="<?= htmlspecialchars($edit['kode_barang'] ?? ''); ?>" required>
  <br><br>

  Nama:
  <input name="nama_barang" value="<?= htmlspecialchars($edit['nama_barang'] ?? ''); ?>" required>
  <br><br>

  Harga:
  <input type="number" name="harga" min="0" value="<?= $edit['harga'] ?? 0; ?>" required>
  <br><br>

  Stok:
  <input type="number" name="stok" min="0" value="<?= $edit['stok'] ?? 0; ?>" required>
  <br><br>

  Supplier:
  <select name="supplier_id" required>
    <option value="">Pilih Supplier</option>

    <?php while ($s = mysqli_fetch_assoc($data_supplier)) { ?>
      <option value="<?= $s['id']; ?>" <?= ($edit['supplier_id'] ?? '') == $s['id'] ? 'selected' : ''; ?>>
        <?= htmlspecialchars($s['nama']); ?>
      </option>
    <?php } ?>
  </select>
  <br><br>

  <button name="simpan">Simpan</button>
  <a href="barang.php">Batal</a>
</form>

<h3>Daftar Barang</h3>

<table border="1" cellpadding="6">
  <tr>
    <th>ID</th>
    <th>Kode</th>
    <th>Nama Barang</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Supplier</th>
    <th>Aksi</th>
  </tr>

  <?php while ($b = mysqli_fetch_assoc($data)) { ?>
    <tr>
      <td><?= $b['id']; ?></td>
      <td><?= htmlspecialchars($b['kode_barang']); ?></td>
      <td><?= htmlspecialchars($b['nama_barang']); ?></td>
      <td>Rp <?= number_format($b['harga'], 0, ',', '.'); ?></td>
      <td><?= $b['stok']; ?></td>
      <td><?= htmlspecialchars($b['nama_supplier']); ?></td>
      <td>
        <a href="barang.php?edit=<?= $b['id']; ?>">Edit</a>

        <form method="post" style="display:inline" onsubmit="return confirm('Hapus barang?')">
          <input type="hidden" name="id" value="<?= $b['id']; ?>">
          <button name="hapus">Hapus</button>
        </form>
      </td>
    </tr>
  <?php } ?>
</table>

</body>
</html>