<?php
include "koneksi.php";

// Kalau dibuka tanpa id, kembali ke daftar transaksi
if (!isset($_GET['id'])) {
    header("Location: transaksi.php");
    exit;
}
$id = (int) $_GET['id'];

// Simpan detail transaksi baru
if (isset($_POST['simpan'])) {
    $barang_id = (int) $_POST['barang_id'];
    $qty       = (int) $_POST['qty'];

    // Harga diambil dari tabel barang
    mysqli_query($koneksi, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
                            SELECT $id, id, harga, $qty FROM barang WHERE id = $barang_id");

    // Hitung ulang total transaksi (harga x qty seluruh detail), simpan ke tabel transaksi
    mysqli_query($koneksi, "UPDATE transaksi
                            SET total = (SELECT SUM(harga * qty) FROM transaksi_detail WHERE transaksi_id = $id)
                            WHERE id = $id");

    header("Location: detail.php?id=$id");
    exit;
}

// Data master
$master = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT t.*, p.nama
                                                     FROM transaksi t
                                                     JOIN pelanggan p ON p.id = t.pelanggan_id
                                                     WHERE t.id = $id"));
if (!$master) {
    die("Transaksi tidak ditemukan");
}

// Data detail
$detail = mysqli_query($koneksi, "SELECT d.*, b.nama_barang
                                  FROM transaksi_detail d
                                  JOIN barang b ON b.id = d.barang_id
                                  WHERE d.transaksi_id = $id");

// Dropdown: hanya barang yang BELUM ada di detail transaksi ini
$barang = mysqli_query($koneksi, "SELECT id, nama_barang, harga FROM barang
                                  WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id = $id)");

$judul = "Detail Transaksi";
$halaman = "transaksi";
include "layout.php";
tampilHeader($judul, $halaman);
?>

<div class="card mb-4">
    <div class="card-header">Transaksi #<?= $master['id'] ?></div>
    <div class="card-body">
        <p class="mb-1">Tanggal: <?= $master['waktu_transaksi'] ?></p>
        <p class="mb-1">Pelanggan: <?= htmlspecialchars($master['nama']) ?></p>
        <p class="mb-1">Keterangan: <?= htmlspecialchars($master['keterangan']) ?></p>
        <p class="mb-0">Total: <b>Rp <?= number_format($master['total']) ?></b></p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">Detail Barang</div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>Barang</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
            <?php while ($d = mysqli_fetch_assoc($detail)) { ?>
            <tr>
                <td><?= htmlspecialchars($d['nama_barang']) ?></td>
                <td>Rp <?= number_format($d['harga']) ?></td>
                <td><?= $d['qty'] ?></td>
                <td>Rp <?= number_format($d['harga'] * $d['qty']) ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">Tambah Barang</div>
    <div class="card-body">
        <?php if (mysqli_num_rows($barang) == 0) { ?>
            <div class="alert alert-secondary mb-0">Semua barang sudah dimasukkan ke transaksi ini.</div>
        <?php } else { ?>
        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Barang</label>
                <select name="barang_id" class="form-select" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
                        <option value="<?= $b['id'] ?>">
                            <?= htmlspecialchars($b['nama_barang']) ?> (Rp <?= number_format($b['harga']) ?>)
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Qty</label>
                <input type="number" name="qty" class="form-control" min="1" value="1" required>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan</button>
            </div>
        </form>
        <?php } ?>
    </div>
</div>

<a href="transaksi.php" class="btn btn-secondary">&laquo; Kembali</a>

<?php tampilFooter(); ?>
