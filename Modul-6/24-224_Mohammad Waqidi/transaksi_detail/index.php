<?php 
require_once "../koneksi.php";
$id = (int)($_GET['id'] ?? 0);
$judul = "Detail Transaksi";
include "../header.php";

$t = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id=$id");
$trans = mysqli_fetch_assoc($t);

if (!$trans) {
    echo '<div class="msg">Transaksi tidak ditemukan.</div>';
    include "../footer.php";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bid = (int)$_POST['barang_id'];
    $qty = (int)$_POST['qty'];
    
    $b = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id=$bid");
    $barang = mysqli_fetch_assoc($b);
    
    if (!$barang || $qty < 1) {
        $pesan = "Barang atau jumlah tidak valid.";
    } else {
        $harga = (int)$barang['harga'];
        $st = mysqli_prepare($koneksi, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($st, "iiii", $id, $bid, $harga, $qty);
        
        if (mysqli_stmt_execute($st)) {
            mysqli_query($koneksi, "UPDATE transaksi SET total = (SELECT COALESCE(SUM(harga * qty), 0) FROM transaksi_detail WHERE transaksi_id = $id) WHERE id = $id");
            header("Location: index.php?id=$id");
            exit;
        } else {
            $pesan = "Barang sudah ada pada detail transaksi ini atau terjadi kesalahan.";
        }
    }
}

$barang = mysqli_query($koneksi, "SELECT * FROM barang WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id=$id) ORDER BY nama_barang");
$detail = mysqli_query($koneksi, "SELECT d.*, b.kode_barang, b.nama_barang FROM transaksi_detail d JOIN barang b ON b.id=d.barang_id WHERE d.transaksi_id=$id");
?>

<h2>Detail Transaksi #<?= $id ?></h2>

<p>Tanggal: <?= htmlspecialchars($trans['waktu_transaksi']) ?> | Total: <b>Rp <?= number_format($trans['total']) ?></b></p>

<?php if (isset($pesan)) { ?>
    <div class="msg"><?= htmlspecialchars($pesan) ?></div>
<?php } ?>

<h3>Tambah Barang</h3>

<form method="post">
    <label>Barang (pilihan hanya barang yang belum dimasukkan)</label>
    <select name="barang_id" required>
        <option value="">-- Pilih barang --</option>
        <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
            <option value="<?= $b['id'] ?>">
                <?= htmlspecialchars($b['kode_barang'] . ' - ' . $b['nama_barang'] . ' (Rp ' . number_format($b['harga']) . ')') ?>
            </option>
        <?php } ?>
    </select>
    
    <label>Qty</label>
    <input name="qty" type="number" min="1" value="1" required>
    
    <button class="btn">Simpan Detail</button>
    <a class="btn danger" href="../transaksi/index.php">Kembali</a>
</form>

<h3>Barang dalam transaksi</h3>

<table>
    <tr>
        <th>Barang</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
    </tr>
    <?php while ($d = mysqli_fetch_assoc($detail)) { ?>
        <tr>
            <td><?= htmlspecialchars($d['kode_barang'] . ' - ' . $d['nama_barang']) ?></td>
            <td><?= number_format($d['harga']) ?></td>
            <td><?= $d['qty'] ?></td>
            <td><?= number_format($d['harga'] * $d['qty']) ?></td>
        </tr>
    <?php } ?>
</table>

<?php include "../footer.php"; ?>