<?php
include "koneksi.php";

// Simpan transaksi baru (master), lalu pindah ke halaman detail
if (isset($_POST['simpan'])) {
    $tanggal   = $_POST['waktu_transaksi'];
    $ket       = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $pelanggan = mysqli_real_escape_string($koneksi, $_POST['pelanggan_id']);

    mysqli_query($koneksi, "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id)
                            VALUES ('$tanggal', '$ket', 0, '$pelanggan')");

    $id_baru = mysqli_insert_id($koneksi);
    header("Location: detail.php?id=$id_baru");
    exit;
}

$pelanggan = mysqli_query($koneksi, "SELECT id, nama FROM pelanggan");
$transaksi = mysqli_query($koneksi, "SELECT t.*, p.nama
                                     FROM transaksi t
                                     JOIN pelanggan p ON p.id = t.pelanggan_id
                                     ORDER BY t.id");

$judul = "Data Transaksi";
$halaman = "transaksi";
include "layout.php";
tampilHeader($judul, $halaman);
?>

<div class="card mb-4">
    <div class="card-header">Tambah Transaksi</div>
    <div class="card-body">
        <form method="post" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="waktu_transaksi" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Pelanggan</label>
                <select name="pelanggan_id" class="form-select" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Keterangan</label>
                <input type="text" name="keterangan" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" name="simpan" class="btn btn-primary w-100">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">Daftar Transaksi</div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Keterangan</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
            <?php while ($t = mysqli_fetch_assoc($transaksi)) { ?>
            <tr>
                <td><?= $t['id'] ?></td>
                <td><?= $t['waktu_transaksi'] ?></td>
                <td><?= htmlspecialchars($t['nama']) ?></td>
                <td><?= htmlspecialchars($t['keterangan']) ?></td>
                <td>Rp <?= number_format($t['total']) ?></td>
                <td><a href="detail.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-secondary">Lihat Detail</a></td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php tampilFooter(); ?>
