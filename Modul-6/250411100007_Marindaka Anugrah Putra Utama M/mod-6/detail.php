<?php
include 'koneksi.php';

$id = (int)($_GET['id'] ?? 0);

// Data master
$stmt = mysqli_prepare($koneksi,
    "SELECT t.*, p.nama AS nama_pelanggan FROM transaksi t
     JOIN pelanggan p ON p.id = t.pelanggan_id WHERE t.id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$master = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$master) { die("Transaksi tidak ditemukan. <a href='transaksi.php'>Kembali</a>"); }

$pesan = "";
if (isset($_POST['tambah'])) {
    $barang_id = (int)$_POST['barang_id'];
    $qty = (int)$_POST['qty'];

    // Cek barang belum pernah diinput di transaksi ini (validasi server side)
    $cek = mysqli_prepare($koneksi,
        "SELECT COUNT(*) FROM transaksi_detail WHERE transaksi_id = ? AND barang_id = ?");
    mysqli_stmt_bind_param($cek, "ii", $id, $barang_id);
    mysqli_stmt_execute($cek);
    mysqli_stmt_bind_result($cek, $sudah);
    mysqli_stmt_fetch($cek);
    mysqli_stmt_close($cek);

    if ($qty < 1) {
        $pesan = "Qty minimal 1.";
    } elseif ($sudah > 0) {
        $pesan = "Barang tersebut sudah ada di transaksi ini.";
    } else {
        mysqli_begin_transaction($koneksi);
        try {
            // harga diambil dari tabel barang
            $ins = mysqli_prepare($koneksi,
                "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
                 SELECT ?, id, harga, ? FROM barang WHERE id = ?");
            mysqli_stmt_bind_param($ins, "iii", $id, $qty, $barang_id);
            mysqli_stmt_execute($ins);

            $upd = mysqli_prepare($koneksi,
                "UPDATE transaksi SET total =
                   (SELECT COALESCE(SUM(harga * qty), 0) FROM transaksi_detail WHERE transaksi_id = ?)
                 WHERE id = ?");
            mysqli_stmt_bind_param($upd, "ii", $id, $id);
            mysqli_stmt_execute($upd);

            mysqli_commit($koneksi);
            header("Location: detail.php?id=$id");
            exit;
        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            $pesan = "Gagal menyimpan: " . $e->getMessage();
        }
    }
}

// Detail transaksi
$stmt = mysqli_prepare($koneksi,
    "SELECT d.barang_id, b.kode_barang, b.nama_barang, d.harga, d.qty, (d.harga * d.qty) AS subtotal
     FROM transaksi_detail d JOIN barang b ON b.id = d.barang_id WHERE d.transaksi_id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$detail = mysqli_stmt_get_result($stmt);

// Dropdown: hanya barang yang BELUM ada di detail transaksi ini
$stmt = mysqli_prepare($koneksi,
    "SELECT id, kode_barang, nama_barang, harga FROM barang
     WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id = ?)
     ORDER BY nama_barang");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$pilihan = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html>
<head><title>Master-Detail Transaksi</title></head>
<body>
<p><a href="transaksi.php">&laquo; Kembali</a></p>

<h2>Master: Transaksi #<?= $master['id'] ?></h2>
<table border="1" cellpadding="5">
  <tr><td>Tanggal</td><td><?= h($master['waktu_transaksi']) ?></td></tr>
  <tr><td>Pelanggan</td><td><?= h($master['nama_pelanggan']) ?></td></tr>
  <tr><td>Keterangan</td><td><?= h($master['keterangan']) ?></td></tr>
  <tr><td>Total</td><td><b>Rp <?= number_format($master['total'], 0, ',', '.') ?></b></td></tr>
</table>

<h2>Detail Transaksi</h2>
<?php if ($pesan) echo "<p style='color:red'>" . h($pesan) . "</p>"; ?>
<table border="1" cellpadding="5">
  <tr><th>Kode</th><th>Barang</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
  <?php while ($d = mysqli_fetch_assoc($detail)) { ?>
  <tr>
    <td><?= h($d['kode_barang']) ?></td>
    <td><?= h($d['nama_barang']) ?></td>
    <td align="right"><?= number_format($d['harga'], 0, ',', '.') ?></td>
    <td align="right"><?= $d['qty'] ?></td>
    <td align="right"><?= number_format($d['subtotal'], 0, ',', '.') ?></td>
  </tr>
  <?php } ?>
</table>

<h3>Tambah Detail</h3>
<?php if (mysqli_num_rows($pilihan) == 0) { ?>
  <p>Semua barang sudah dimasukkan ke transaksi ini.</p>
<?php } else { ?>
<form method="post">
  Barang:
  <select name="barang_id" required>
    <option value="">pilih barang</option>
    <?php while ($b = mysqli_fetch_assoc($pilihan)) { ?>
      <option value="<?= $b['id'] ?>">
        <?= h($b['kode_barang'] . ' - ' . $b['nama_barang']) ?> (Rp <?= number_format($b['harga'], 0, ',', '.') ?>)
      </option>
    <?php } ?>
  </select>
  Qty: <input type="number" name="qty" min="1" value="1" required>
  <button type="submit" name="tambah">Simpan Detail</button>
</form>
<?php } ?>
</body>
</html>