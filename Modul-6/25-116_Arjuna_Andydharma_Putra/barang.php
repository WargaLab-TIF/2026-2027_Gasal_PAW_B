<?php
require_once 'koneksi.php';

$pesan = '';
$tipe_pesan = '';

if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $cek = mysqli_query($koneksi, "SELECT COUNT(*) AS jml FROM transaksi_detail WHERE barang_id = $id");
    $jml = mysqli_fetch_assoc($cek)['jml'];

    if ($jml > 0) {
        $pesan = "Barang tidak dapat dihapus! Barang ini masih digunakan pada $jml transaksi detail.";
        $tipe_pesan = 'danger';
    } else {
        // Cek juga di tabel barang apakah ada
        $cek_brg = mysqli_query($koneksi, "SELECT nama_barang FROM barang WHERE id = $id");
        if (mysqli_num_rows($cek_brg) > 0) {
            $nama = mysqli_fetch_assoc($cek_brg)['nama_barang'];
            mysqli_query($koneksi, "DELETE FROM barang WHERE id = $id");
            $pesan = "Barang \"$nama\" berhasil dihapus.";
            $tipe_pesan = 'success';
        } else {
            $pesan = "Data barang tidak ditemukan.";
            $tipe_pesan = 'warning';
        }
    }
}

if (isset($_POST['tambah_barang'])) {
    $kode = mysqli_real_escape_string($koneksi, $_POST['kode_barang']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $harga = (int)$_POST['harga'];
    $stok = (int)$_POST['stok'];
    $supplier_id = (int)$_POST['supplier_id'];

    $sql = "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) 
            VALUES ('$kode', '$nama', $harga, $stok, $supplier_id)";
    if (mysqli_query($koneksi, $sql)) {
        $pesan = "Barang berhasil ditambahkan.";
        $tipe_pesan = 'success';
    } else {
        $pesan = "Gagal menambah barang: " . mysqli_error($koneksi);
        $tipe_pesan = 'danger';
    }
}

$query = "SELECT b.*, s.nama AS nama_supplier,
          (SELECT COUNT(*) FROM transaksi_detail td WHERE td.barang_id = b.id) AS jml_pakai
          FROM barang b
          LEFT JOIN supplier s ON b.supplier_id = s.id
          ORDER BY b.id";
$result = mysqli_query($koneksi, $query);

$list_supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY nama");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background: #f4f6f9; }
        .navbar { background: linear-gradient(135deg, #1e3a5f, #2c5282); }
        .card { border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
    </style>
</head>
<body>
<nav class="navbar navbar-dark mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            <i class="bi bi-shop"></i> Penjualan
        </a>
        <div class="d-flex gap-2">
            <a href="transaksi.php" class="btn btn-outline-light btn-sm">Transaksi</a>
            <a href="barang.php" class="btn btn-light btn-sm">Barang</a>
        </div>
    </div>
</nav>

<div class="container">
    <?php if ($pesan): ?>
    <div class="alert alert-<?= $tipe_pesan ?> alert-dismissible fade show">
        <?= $pesan ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="bi bi-box-seam"></i> Data Barang</span>
            <button class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg"></i> Tambah Barang
            </button>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th class="text-end">Harga</th>
                            <th class="text-center">Stok</th>
                            <th>Supplier</th>
                            <th class="text-center">Dipakai di Transaksi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><code><?= htmlspecialchars($row['kode_barang']) ?></code></td>
                            <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                            <td class="text-end">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <td class="text-center"><?= $row['stok'] ?></td>
                            <td><?= htmlspecialchars($row['nama_supplier'] ?? '-') ?></td>
                            <td class="text-center">
                                <?php if ($row['jml_pakai'] > 0): ?>
                                    <span class="badge bg-warning text-dark"><?= $row['jml_pakai'] ?>x</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if ($row['jml_pakai'] > 0): ?>
                                    <button class="btn btn-sm btn-outline-secondary" disabled title="Tidak bisa dihapus karena masih dipakai">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                <?php else: ?>
                                    <a href="?hapus=<?= $row['id'] ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Yakin hapus barang ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer text-muted small">
            <i class="bi bi-info-circle"></i> 
            Barang yang sudah dipakai di transaksi_detail tidak dapat dihapus (sesuai ketentuan tugas).
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form method="post" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" min="0" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" min="0" value="0" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Supplier</label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">-- Pilih Supplier --</option>
                        <?php while ($s = mysqli_fetch_assoc($list_supplier)): ?>
                        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" name="tambah_barang" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
