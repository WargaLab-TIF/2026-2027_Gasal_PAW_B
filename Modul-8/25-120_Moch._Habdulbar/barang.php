<?php
require 'config.php';
wajib_level(1);
$aksi  = $_GET['aksi'] ?? '';
$pesan = '';
$row   = ['id' => 0, 'kode_barang' => '', 'nama_barang' => '', 'harga' => '', 'stok' => '', 'supplier_id' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['hapus'])) {
        try {
            $s = mysqli_prepare($conn, "DELETE FROM barang WHERE id=?");
            mysqli_stmt_bind_param($s, 'i', $_POST['hapus']);
            mysqli_stmt_execute($s);
            flash('Data barang berhasil dihapus.');
            header('Location: barang.php'); exit;
        } catch (mysqli_sql_exception $e) {
            $pesan = 'Barang tidak dapat dihapus karena sudah dipakai pada transaksi.';
        }
    } else {
        $id = (int)$_POST['id'];
        $kode = trim($_POST['kode_barang']); $nama = trim($_POST['nama_barang']);
        $harga = $_POST['harga']; $stok = $_POST['stok']; $sup = (int)$_POST['supplier_id'];
        $row = ['id' => $id, 'kode_barang' => $kode, 'nama_barang' => $nama, 'harga' => $harga, 'stok' => $stok, 'supplier_id' => $sup];
        $aksi = $id ? 'edit' : 'tambah';
        if ($kode === '' || $nama === '' || $sup <= 0) {
            $pesan = 'Kode, nama barang, dan supplier wajib diisi.';
        } elseif (!ctype_digit((string)$harga) || !ctype_digit((string)$stok)) {
            $pesan = 'Harga dan stok harus berupa angka (tidak negatif).';
        } else {
            $harga = (int)$harga; $stok = (int)$stok;
            try {
                if ($id) {
                    $s = mysqli_prepare($conn, "UPDATE barang SET kode_barang=?, nama_barang=?, harga=?, stok=?, supplier_id=? WHERE id=?");
                    mysqli_stmt_bind_param($s, 'ssiiii', $kode, $nama, $harga, $stok, $sup, $id);
                } else {
                    $s = mysqli_prepare($conn, "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES (?,?,?,?,?)");
                    mysqli_stmt_bind_param($s, 'ssiii', $kode, $nama, $harga, $stok, $sup);
                }
                mysqli_stmt_execute($s);
                flash('Data barang berhasil disimpan.');
                header('Location: barang.php'); exit;
            } catch (mysqli_sql_exception $e) {
                $pesan = 'Gagal menyimpan. Kode barang sudah dipakai atau data tidak valid.';
            }
        }
    }
}
if ($aksi == 'edit' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $s = mysqli_prepare($conn, "SELECT * FROM barang WHERE id=?");
    mysqli_stmt_bind_param($s, 'i', $_GET['id']);
    mysqli_stmt_execute($s);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($s)) ?: $row;
}
include 'header.php';
?>
<h3>Data Barang</h3>
<?php if ($pesan) { ?><div class="alert alert-danger"><?= h($pesan) ?></div><?php } ?>

<?php if ($aksi == 'tambah' || $aksi == 'edit') { ?>
<form method="post" class="form-horizontal" style="max-width:600px">
  <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
  <div class="form-group"><label class="col-sm-3 control-label">Kode Barang</label>
    <div class="col-sm-9"><input type="text" name="kode_barang" class="form-control" maxlength="10" value="<?= h($row['kode_barang']) ?>"></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Nama Barang</label>
    <div class="col-sm-9"><input type="text" name="nama_barang" class="form-control" maxlength="100" value="<?= h($row['nama_barang']) ?>"></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Harga</label>
    <div class="col-sm-9"><input type="number" min="0" name="harga" class="form-control" value="<?= h($row['harga']) ?>"></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Stok</label>
    <div class="col-sm-9"><input type="number" min="0" name="stok" class="form-control" value="<?= h($row['stok']) ?>"></div></div>
  <div class="form-group"><label class="col-sm-3 control-label">Supplier</label>
    <div class="col-sm-9">
      <select name="supplier_id" class="form-control">
        <option value="">-- Pilih Supplier --</option>
        <?php $q = mysqli_query($conn, "SELECT id, nama FROM supplier ORDER BY nama");
        while ($sp = mysqli_fetch_assoc($q)) { ?>
        <option value="<?= $sp['id'] ?>" <?= $row['supplier_id'] == $sp['id'] ? 'selected' : '' ?>><?= h($sp['nama']) ?></option>
        <?php } ?>
      </select>
    </div></div>
  <div class="form-group"><div class="col-sm-offset-3 col-sm-9">
    <button class="btn btn-primary">Simpan</button> <a href="barang.php" class="btn btn-default">Batal</a></div></div>
</form>
<?php } else { ?>
<a href="?aksi=tambah" class="btn btn-primary" style="margin-bottom:10px">Tambah Barang</a>
<table class="table table-bordered table-striped">
  <tr><th>No</th><th>Kode</th><th>Nama Barang</th><th>Harga</th><th>Stok</th><th>Supplier</th><th width="140">Aksi</th></tr>
  <?php $no = 1;
  $q = mysqli_query($conn, "SELECT b.*, s.nama AS supplier FROM barang b JOIN supplier s ON s.id=b.supplier_id ORDER BY b.id");
  while ($r = mysqli_fetch_assoc($q)) { ?>
  <tr>
    <td><?= $no++ ?></td><td><?= h($r['kode_barang']) ?></td><td><?= h($r['nama_barang']) ?></td>
    <td><?= rp($r['harga']) ?></td><td><?= $r['stok'] ?></td><td><?= h($r['supplier']) ?></td>
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
