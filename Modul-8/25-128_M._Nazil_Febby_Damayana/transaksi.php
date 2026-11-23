<?php
include 'koneksi.php';
include 'cek.php';

$pesan = '';

if (isset($_POST['simpan'])) {
    $tanggal = esc($_POST['tanggal']);
    $plg     = esc($_POST['pelanggan_id']);
    $ket     = esc($_POST['keterangan']);
    $metode  = esc($_POST['metode']);

    $item  = [];
    $total = 0;
    for ($i = 0; $i < count($_POST['barang_id']); $i++) {
        $bid = (int) $_POST['barang_id'][$i];
        $qty = (int) $_POST['qty'][$i];
        if ($bid == 0 || $qty <= 0) {
            continue;
        }
        $b = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM barang WHERE id=$bid"));
        if (!$b || $b['stok'] < $qty) {
            $pesan = 'Stok ' . ($b['nama_barang'] ?? 'barang') . ' tidak cukup.';
            break;
        }
        $item[] = ['id' => $bid, 'harga' => $b['harga'], 'qty' => $qty];
        $total += $b['harga'] * $qty;
    }

    if ($pesan == '' && count($item) == 0) {
        $pesan = 'Pilih minimal satu barang.';
    }

    if ($pesan == '') {
        mysqli_query($conn, "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES ('$tanggal','$ket',$total,'$plg')");
        $tid = mysqli_insert_id($conn);
        foreach ($item as $it) {
            mysqli_query($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES ($tid,{$it['id']},{$it['harga']},{$it['qty']})
                                 ON DUPLICATE KEY UPDATE qty = qty + {$it['qty']}");
            mysqli_query($conn, "UPDATE barang SET stok = stok - {$it['qty']} WHERE id={$it['id']}");
        }
        mysqli_query($conn, "INSERT INTO pembayaran (waktu_bayar, total, metode, transaksi_id) VALUES (NOW(),$total,'$metode',$tid)");
        header("Location: transaksi.php?detail=$tid");
        exit;
    }
}

$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY nama");
$barang    = mysqli_query($conn, "SELECT * FROM barang WHERE stok > 0 ORDER BY nama_barang");
$listBarang = [];
while ($b = mysqli_fetch_assoc($barang)) {
    $listBarang[] = $b;
}
$data = mysqli_query($conn, "SELECT t.*, p.nama AS pelanggan FROM transaksi t LEFT JOIN pelanggan p ON p.id = t.pelanggan_id ORDER BY t.id ASC");

include 'header.php';
?>
<h4>Transaksi</h4>
<?php if ($pesan) { ?><div class="alert alert-danger"><?= h($pesan) ?></div><?php } ?>

<?php
if (isset($_GET['detail'])) {
    $id  = (int) $_GET['detail'];
    $trx = mysqli_fetch_assoc(mysqli_query($conn, "SELECT t.*, p.nama AS pelanggan FROM transaksi t LEFT JOIN pelanggan p ON p.id=t.pelanggan_id WHERE t.id=$id"));
    if ($trx) {
        $det = mysqli_query($conn, "SELECT d.*, b.nama_barang FROM transaksi_detail d JOIN barang b ON b.id=d.barang_id WHERE d.transaksi_id=$id");
?>
<div class="card card-body mb-4">
    <h6>Detail Transaksi #<?= $trx['id'] ?> - <?= h($trx['pelanggan']) ?> (<?= $trx['waktu_transaksi'] ?>)</h6>
    <table class="table table-sm">
        <tr><th>Barang</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
        <?php while ($d = mysqli_fetch_assoc($det)) { ?>
        <tr><td><?= h($d['nama_barang']) ?></td><td><?= rp($d['harga']) ?></td><td><?= $d['qty'] ?></td><td><?= rp($d['harga'] * $d['qty']) ?></td></tr>
        <?php } ?>
        <tr><th colspan="3" class="text-end">Total</th><th><?= rp($trx['total']) ?></th></tr>
    </table>
</div>
<?php } } ?>

<form method="post" class="card card-body mb-4">
    <h6>Transaksi Baru</h6>
    <div class="row g-2 mb-2">
        <div class="col-md-3"><input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required></div>
        <div class="col-md-4">
            <select name="pelanggan_id" class="form-select" required>
                <option value="">-- Pelanggan --</option>
                <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>
                    <option value="<?= h($p['id']) ?>"><?= h($p['nama']) ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="metode" class="form-select">
                <option>TUNAI</option><option>TRANSFER</option><option>EDC</option>
            </select>
        </div>
        <div class="col-md-3"><input name="keterangan" class="form-control" placeholder="Keterangan"></div>
    </div>

    <?php for ($i = 0; $i < 4; $i++) { ?>
    <div class="row g-2 mb-2">
        <div class="col-md-9">
            <select name="barang_id[]" class="form-select">
                <option value="0">-- Pilih Barang --</option>
                <?php foreach ($listBarang as $b) { ?>
                    <option value="<?= $b['id'] ?>"><?= h($b['nama_barang']) ?> - <?= rp($b['harga']) ?> (stok <?= $b['stok'] ?>)</option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md-3"><input type="number" name="qty[]" class="form-control" placeholder="Qty" min="0" value="0"></div>
    </div>
    <?php } ?>
    <div><button name="simpan" class="btn btn-success">Simpan Transaksi</button></div>
</form>

<table class="table table-bordered table-striped">
    <tr><th>ID</th><th>Tanggal</th><th>Pelanggan</th><th>Keterangan</th><th>Total</th><th>Aksi</th></tr>
    <?php while ($d = mysqli_fetch_assoc($data)) { ?>
    <tr>
        <td><?= $d['id'] ?></td>
        <td><?= $d['waktu_transaksi'] ?></td>
        <td><?= h($d['pelanggan']) ?></td>
        <td><?= h($d['keterangan']) ?></td>
        <td><?= rp($d['total']) ?></td>
        <td><a href="?detail=<?= $d['id'] ?>" class="btn btn-info btn-sm">Detail</a></td>
    </tr>
    <?php } ?>
</table>
<?php include 'footer.php'; ?>