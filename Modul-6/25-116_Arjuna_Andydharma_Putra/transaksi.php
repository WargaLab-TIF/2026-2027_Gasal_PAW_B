<?php
require_once 'koneksi.php';

if (isset($_POST['tambah_transaksi'])) {
    $waktu = $_POST['waktu_transaksi'];
    $ket   = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $pel   = $_POST['pelanggan_id'];
    mysqli_query($koneksi, "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) 
                            VALUES ('$waktu', '$ket', 0, '$pel')");
    header("Location: transaksi.php?id=" . mysqli_insert_id($koneksi));
    exit;
}

if (isset($_POST['tambah_detail'])) {
    $transaksi_id = (int)$_POST['transaksi_id'];
    $barang_id    = (int)$_POST['barang_id'];
    $harga        = (int)$_POST['harga'];
    $qty          = (int)$_POST['qty'];

    $cek = mysqli_query($koneksi, "SELECT id FROM transaksi_detail WHERE transaksi_id=$transaksi_id AND barang_id=$barang_id");
    if (mysqli_num_rows($cek) > 0) {
        $pesan_error = "Barang sudah ada di detail transaksi ini!";
    } else {
        mysqli_query($koneksi, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) 
                                VALUES ($transaksi_id, $barang_id, $harga, $qty)");

        $sum = mysqli_query($koneksi, "SELECT COALESCE(SUM(harga * qty),0) AS total FROM transaksi_detail WHERE transaksi_id=$transaksi_id");
        $total = mysqli_fetch_assoc($sum)['total'];
        mysqli_query($koneksi, "UPDATE transaksi SET total=$total WHERE id=$transaksi_id");

        header("Location: transaksi.php?id=$transaksi_id");
        exit;
    }
}

if (isset($_GET['hapus_detail'])) {
    $id_detail = (int)$_GET['hapus_detail'];
    $tid = (int)$_GET['tid'];
    mysqli_query($koneksi, "DELETE FROM transaksi_detail WHERE id=$id_detail");

    $sum = mysqli_query($koneksi, "SELECT COALESCE(SUM(harga * qty),0) AS total FROM transaksi_detail WHERE transaksi_id=$tid");
    $total = mysqli_fetch_assoc($sum)['total'];
    mysqli_query($koneksi, "UPDATE transaksi SET total=$total WHERE id=$tid");
    
    header("Location: transaksi.php?id=$tid");
    exit;
}

$id_transaksi = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$transaksi = null;
if ($id_transaksi > 0) {
    $q = mysqli_query($koneksi, "SELECT t.*, p.nama AS nama_pelanggan 
                                 FROM transaksi t 
                                 LEFT JOIN pelanggan p ON t.pelanggan_id = p.id 
                                 WHERE t.id = $id_transaksi");
    $transaksi = mysqli_fetch_assoc($q);
}

$list_transaksi = mysqli_query($koneksi, "SELECT t.*, p.nama AS nama_pelanggan 
                                          FROM transaksi t 
                                          LEFT JOIN pelanggan p ON t.pelanggan_id = p.id 
                                          ORDER BY t.id DESC");

$list_pelanggan = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY nama");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master-Detail Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f4f6f9; }
        .navbar { background: linear-gradient(135deg, #1e3a5f, #2c5282); }
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .table-master tr { cursor: pointer; }
        .table-master tr:hover { background: #e8f0fe; }
        .table-master tr.active { background: #cfe2ff !important; }
        .badge-total { font-size: 1rem; }
    </style>
</head>
<body>
<nav class="navbar navbar-dark mb-4">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-shop"></i> Penjualan
        </a>
        <div class="d-flex gap-2">
            <a href="transaksi.php" class="btn btn-light btn-sm">Transaksi</a>
            <a href="barang.php" class="btn btn-outline-light btn-sm">Barang</a>
        </div>
    </div>
</nav>

<div class="container-fluid px-4">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-receipt"></i> Daftar Transaksi</span>
                    <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalTambahTransaksi">
                        <i class="bi bi-plus-lg"></i> Baru
                    </button>
                </div>
                <div class="card-body p-0" style="max-height: 70vh; overflow-y: auto;">
                    <table class="table table-hover table-master mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($list_transaksi)): ?>
                            <tr class="<?= ($id_transaksi == $row['id']) ? 'active' : '' ?>"
                                onclick="location.href='transaksi.php?id=<?= $row['id'] ?>'">
                                <td><strong>#<?= $row['id'] ?></strong></td>
                                <td><?= date('d/m/Y', strtotime($row['waktu_transaksi'])) ?></td>
                                <td><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
                                <td><span class="badge bg-success badge-total">Rp <?= number_format($row['total'], 0, ',', '.') ?></span></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- DETAIL -->
        <div class="col-lg-7">
            <?php if ($transaksi): ?>
            <div class="card mb-3">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-info-circle"></i> Detail Transaksi #<?= $transaksi['id'] ?>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-sm table-borderless mb-0">
                                <tr><th width="40%">Tanggal</th><td><?= date('d F Y', strtotime($transaksi['waktu_transaksi'])) ?></td></tr>
                                <tr><th>Pelanggan</th><td><?= htmlspecialchars($transaksi['nama_pelanggan'] ?? '-') ?></td></tr>
                                <tr><th>Keterangan</th><td><?= htmlspecialchars($transaksi['keterangan'] ?? '-') ?></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="fs-5 text-muted">Total Transaksi</div>
                            <div class="fs-3 fw-bold text-success">Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Tambah Detail -->
            <div class="card mb-3">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-plus-circle"></i> Tambah Item Detail
                </div>
                <div class="card-body">
                    <?php if (isset($pesan_error)): ?>
                        <div class="alert alert-danger py-2"><?= $pesan_error ?></div>
                    <?php endif; ?>
                    <form method="post" class="row g-2 align-items-end">
                        <input type="hidden" name="transaksi_id" value="<?= $transaksi['id'] ?>">
                        <div class="col-md-5">
                            <label class="form-label small">Barang</label>
                            <select name="barang_id" id="barang_id" class="form-select form-select-sm" required onchange="isiHarga(this)">
                                <option value="">-- Pilih Barang --</option>
                                <?php
                                // Ambil barang yang BELUM ada di detail transaksi ini
                                $barang_sudah = [];
                                $q_sudah = mysqli_query($koneksi, "SELECT barang_id FROM transaksi_detail WHERE transaksi_id={$transaksi['id']}");
                                while ($s = mysqli_fetch_assoc($q_sudah)) {
                                    $barang_sudah[] = $s['barang_id'];
                                }

                                $q_barang = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama_barang");
                                while ($b = mysqli_fetch_assoc($q_barang)):
                                    $disabled = in_array($b['id'], $barang_sudah) ? 'disabled' : '';
                                    $label = $disabled ? $b['nama_barang'] . ' (sudah dipilih)' : $b['nama_barang'];
                                ?>
                                <option value="<?= $b['id'] ?>" 
                                        data-harga="<?= $b['harga'] ?>" 
                                        <?= $disabled ?>
                                        <?= $disabled ? 'style="color:#999"' : '' ?>>
                                    <?= htmlspecialchars($label) ?> - Rp <?= number_format($b['harga'],0,',','.') ?>
                                </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small">Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control form-control-sm" required readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small">Qty</label>
                            <input type="number" name="qty" class="form-control form-control-sm" value="1" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="tambah_detail" class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-plus-lg"></i> Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabel Detail -->
            <div class="card">
                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-list-ul"></i> Item Detail Transaksi
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $q_detail = mysqli_query($koneksi, "SELECT td.*, b.kode_barang, b.nama_barang 
                                                                FROM transaksi_detail td 
                                                                JOIN barang b ON td.barang_id = b.id 
                                                                WHERE td.transaksi_id = {$transaksi['id']}
                                                                ORDER BY td.id");
                            $no = 1;
                            $ada_detail = false;
                            while ($d = mysqli_fetch_assoc($q_detail)):
                                $ada_detail = true;
                                $sub = $d['harga'] * $d['qty'];
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><code><?= $d['kode_barang'] ?></code></td>
                                <td><?= htmlspecialchars($d['nama_barang']) ?></td>
                                <td class="text-end">Rp <?= number_format($d['harga'],0,',','.') ?></td>
                                <td class="text-center"><?= $d['qty'] ?></td>
                                <td class="text-end fw-semibold">Rp <?= number_format($sub,0,',','.') ?></td>
                                <td>
                                    <a href="?hapus_detail=<?= $d['id'] ?>&tid=<?= $transaksi['id'] ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Hapus item ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            <?php if (!$ada_detail): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada item detail</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php else: ?>
            <div class="card">
                <div class="card-body text-center text-muted py-5">
                    <i class="bi bi-arrow-left-circle fs-1 d-block mb-3"></i>
                    Pilih transaksi di sebelah kiri untuk melihat detail,<br>
                    atau klik tombol <strong>Baru</strong> untuk membuat transaksi baru.
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal Tambah Transaksi -->
<div class="modal fade" id="modalTambahTransaksi" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Transaksi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tanggal Transaksi</label>
                    <input type="date" name="waktu_transaksi" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pelanggan</label>
                    <select name="pelanggan_id" class="form-select" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php 
                        mysqli_data_seek($list_pelanggan, 0);
                        while ($p = mysqli_fetch_assoc($list_pelanggan)): ?>
                        <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?> (<?= $p['id'] ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="tambah_transaksi" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function isiHarga(select) {
    const opt = select.options[select.selectedIndex];
    document.getElementById('harga').value = opt.dataset.harga || '';
}
</script>
</body>
</html>
