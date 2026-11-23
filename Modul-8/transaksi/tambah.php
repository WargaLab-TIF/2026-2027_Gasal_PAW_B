<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../koneksi.php';

if (isset($_POST['simpan'])) {
    $pelanggan_id = trim($_POST['pelanggan_id'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    if ($pelanggan_id == '') {
        $pesan = "Silakan pilih pelanggan terlebih dahulu.";
    } else {
        $query = mysqli_prepare($conn, "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES (NOW(), ?, 0, ?)");

        if (!$query) {
            $pesan = "Query gagal: " . mysqli_error($conn);
        } else {
            mysqli_stmt_bind_param($query, "ss", $keterangan, $pelanggan_id);

            if (mysqli_stmt_execute($query)) {
                $id = mysqli_insert_id($conn);

                header("Location: tambah_detail.php?id=" . $id);
                exit;
            } else {
                $pesan = "Transaksi gagal disimpan: " . mysqli_stmt_error($query);
            }
        }
    }
}

$pelanggan = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY nama ASC");

include '../navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Transaksi</h4>
        </div>

        <div class="card-body">

            <?php if (isset($pesan)) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($pesan); ?>
                </div>
            <?php } ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Pelanggan</label>
                    <select name="pelanggan_id" class="form-select" required>
                        <option value="">Pilih Pelanggan</option>

                        <?php while ($p = mysqli_fetch_assoc($pelanggan)) { ?>
                            <option value="<?= htmlspecialchars($p['id']); ?>"
                                <?= (isset($pelanggan_id) && $pelanggan_id == $p['id']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($p['nama']); ?>
                            </option>
                        <?php } ?>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"
                        placeholder="Masukkan keterangan transaksi"><?= htmlspecialchars($keterangan ?? ''); ?></textarea>
                </div>

                <button type="submit" name="simpan" class="btn btn-success">
                    Simpan dan Tambah Barang
                </button>

                <a href="index.php" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>
</div>

</body>
</html>
