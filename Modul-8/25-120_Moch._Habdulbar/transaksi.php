<?php
require 'config.php';
wajib_login();
$aksi  = $_GET['aksi'] ?? '';
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['hapus'])) {
        // kembalikan stok lalu hapus transaksi (detail & pembayaran ikut terhapus)
        mysqli_begin_transaction($conn);
        try {
            $tid = (int)$_POST['hapus'];
            mysqli_query($conn, "UPDATE barang b JOIN transaksi_detail d ON d.barang_id=b.id SET b.stok=b.stok+d.qty WHERE d.transaksi_id=$tid");
            mysqli_query($conn, "DELETE FROM transaksi WHERE id=$tid");
            mysqli_commit($conn);
            flash('Transaksi berhasil dihapus.');
            header('Location: transaksi.php'); exit;
        } catch (mysqli_sql_exception $e) {
            mysqli_rollback($conn);
            $pesan = 'Transaksi gagal dihapus.';
        }
    } else {
        $aksi = 'tambah';
        mysqli_begin_transaction($conn);
        try {
            $pelanggan = $_POST['pelanggan_id'] ?? '';
            $tanggal   = $_POST['waktu_transaksi'] ?? '';
            $ket       = trim($_POST['keterangan'] ?? '');
            $metode    = $_POST['metode'] ?? '';
            if ($pelanggan === '' || $tanggal === '') throw new Exception('Pelanggan dan tanggal wajib diisi.');
            if (!in_array($metode, ['TUNAI', 'TRANSFER', 'EDC'])) throw new Exception('Metode pembayaran tidak valid.');

            $items = [];
            foreach ($_POST['barang_id'] as $i => $bid) {
                $bid = (int)$bid; $q = (int)$_POST['qty'][$i];
                if ($bid > 0 && $q > 0) $items[$bid] = ($items[$bid] ?? 0) + $q;
            }
            if (!$items) throw new Exception('Pilih minimal satu barang dengan qty lebih dari 0.');

            $s = mysqli_prepare($conn, "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES (?,?,0,?)");
            mysqli_stmt_bind_param($s, 'sss', $tanggal, $ket, $pelanggan);
            mysqli_stmt_execute($s);
            $tid = mysqli_insert_id($conn);

            $total = 0;
            foreach ($items as $bid => $qty) {
                $b = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_barang, harga, stok FROM barang WHERE id=$bid FOR UPDATE"));
                if (!$b) throw new Exception('Barang tidak ditemukan.');
                if ($b['stok'] < $qty) throw new Exception('Stok ' . $b['nama_barang'] . ' tidak cukup (sisa ' . $b['stok'] . ').');
                $s = mysqli_prepare($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES (?,?,?,?)");
                mysqli_stmt_bind_param($s, 'iiii', $tid, $bid, $b['harga'], $qty);
                mysqli_stmt_execute($s);
                mysqli_query($conn, "UPDATE barang SET stok=stok-$qty WHERE id=$bid");
                $total += $b['harga'] * $qty;
            }
            mysqli_query($conn, "UPDATE transaksi SET total=$total WHERE id=$tid");
            $s = mysqli_prepare($conn, "INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES (NOW(),?,?,?)");
            mysqli_stmt_bind_param($s, 'isi', $total, $metode, $tid);
            mysqli_stmt_execute($s);

            mysqli_commit($conn);
            flash('Transaksi berhasil disimpan.');
            header('Location: transaksi.php'); exit;
        } catch (mysqli_sql_exception $e) {
            mysqli_rollback($conn);
            $pesan = 'Transaksi gagal disimpan.';
        } catch (Exception $e) {
            mysqli_rollback($conn);
            $pesan = $e->getMessage();
        }
    }
}
include 'header.php';
?>
<h3>Transaksi</h3>
<?php if ($pesan) { ?><div class="alert alert-danger"><?= h($pesan) ?></div><?php } ?>

<?php if ($aksi == 'tambah') {
  $barang = []; $q = mysqli_query($conn, "SELECT id, kode_barang, nama_barang, harga, stok FROM barang WHERE stok>0 ORDER BY nama_barang");
  while ($r = mysqli_fetch_assoc($q)) $barang[] = $r;
  $opsi = '<option value="">-- Pilih Barang --</option>';
  foreach ($barang as $b) $opsi .= '<option value="' . $b['id'] . '">' . h($b['nama_barang']) . ' - ' . rp($b['harga']) . ' (stok ' . $b['stok'] . ')</option>';
?>
<form method="post" style="max-width:800px">
  <div class="row">
    <div class="col-sm-4 form-group"><label>Tanggal</label>
      <input type="date" name="waktu_transaksi" class="form-control" value="<?= h($_POST['waktu_transaksi'] ?? date('Y-m-d')) ?>"></div>
    <div class="col-sm-4 form-group"><label>Pelanggan</label>
      <select name="pelanggan_id" class="form-control">
        <option value="">-- Pilih Pelanggan --</option>
        <?php $q = mysqli_query($conn, "SELECT id, nama FROM pelanggan ORDER BY nama");
        while ($p = mysqli_fetch_assoc($q)) { ?>
        <option value="<?= h($p['id']) ?>" <?= ($_POST['pelanggan_id'] ?? '') == $p['id'] ? 'selected' : '' ?>><?= h($p['nama']) ?></option>
        <?php } ?>
      </select></div>
    <div class="col-sm-4 form-group"><label>Metode Bayar</label>
      <select name="metode" class="form-control">
        <option>TUNAI</option><option>TRANSFER</option><option>EDC</option>
      </select></div>
  </div>
  <div class="form-group"><label>Keterangan</label>
    <input type="text" name="keterangan" class="form-control" value="<?= h($_POST['keterangan'] ?? '') ?>"></div>

  <table class="table table-bordered" id="tbl">
    <tr><th>Barang</th><th width="120">Qty</th><th width="60"></th></tr>
    <tr>
      <td><select name="barang_id[]" class="form-control"><?= $opsi ?></select></td>
      <td><input type="number" min="1" name="qty[]" class="form-control" value="1"></td>
      <td><button type="button" class="btn btn-danger btn-sm" onclick="hapusBaris(this)">X</button></td>
    </tr>
  </table>
  <button type="button" class="btn btn-default" onclick="tambahBaris()">+ Tambah Barang</button>
  <button class="btn btn-primary">Simpan Transaksi</button>
  <a href="transaksi.php" class="btn btn-default">Batal</a>
</form>
<script>
function tambahBaris() {
  var t = document.getElementById('tbl');
  var baris = t.rows[1].cloneNode(true);
  baris.querySelector('select').value = '';
  baris.querySelector('input').value = 1;
  t.appendChild(baris);
}
function hapusBaris(btn) {
  var t = document.getElementById('tbl');
  if (t.rows.length > 2) btn.closest('tr').remove();
}
</script>

<?php } elseif ($aksi == 'detail') {
  $tid = (int)($_GET['id'] ?? 0);
  $t = mysqli_fetch_assoc(mysqli_query($conn, "SELECT t.*, p.nama AS pelanggan FROM transaksi t JOIN pelanggan p ON p.id=t.pelanggan_id WHERE t.id=$tid"));
  if (!$t) { echo '<div class="alert alert-danger">Transaksi tidak ditemukan.</div>'; }
  else { ?>
<p>No: <b><?= $t['id'] ?></b> | Tanggal: <b><?= h($t['waktu_transaksi']) ?></b> | Pelanggan: <b><?= h($t['pelanggan']) ?></b><br>Keterangan: <?= h($t['keterangan']) ?></p>
<table class="table table-bordered">
  <tr><th>Barang</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
  <?php $q = mysqli_query($conn, "SELECT d.*, b.nama_barang FROM transaksi_detail d JOIN barang b ON b.id=d.barang_id WHERE d.transaksi_id=$tid");
  while ($d = mysqli_fetch_assoc($q)) { ?>
  <tr><td><?= h($d['nama_barang']) ?></td><td><?= rp($d['harga']) ?></td><td><?= $d['qty'] ?></td><td><?= rp($d['harga'] * $d['qty']) ?></td></tr>
  <?php } ?>
  <tr><th colspan="3" class="text-right">Total</th><th><?= rp($t['total']) ?></th></tr>
</table>
<a href="transaksi.php" class="btn btn-default">Kembali</a>
<?php } } else { ?>
<a href="?aksi=tambah" class="btn btn-primary" style="margin-bottom:10px">Tambah Transaksi</a>
<table class="table table-bordered table-striped">
  <tr><th>No</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total</th><th width="140">Aksi</th></tr>
  <?php $q = mysqli_query($conn, "SELECT t.*, p.nama AS pelanggan FROM transaksi t JOIN pelanggan p ON p.id=t.pelanggan_id ORDER BY t.waktu_transaksi DESC, t.id DESC");
  while ($r = mysqli_fetch_assoc($q)) { ?>
  <tr>
    <td><?= $r['id'] ?></td><td><?= h($r['waktu_transaksi']) ?></td><td><?= h($r['pelanggan']) ?></td>
    <td><?= h($r['keterangan']) ?></td><td><?= rp($r['total']) ?></td>
    <td>
      <a href="?aksi=detail&id=<?= $r['id'] ?>" class="btn btn-xs btn-info">Detail</a>
      <form method="post" style="display:inline" onsubmit="return confirm('Hapus transaksi ini? Stok akan dikembalikan.')">
        <input type="hidden" name="hapus" value="<?= $r['id'] ?>"><button class="btn btn-xs btn-danger">Hapus</button>
      </form>
    </td>
  </tr>
  <?php } ?>
</table>
<?php } ?>
<?php include 'footer.php'; ?>
