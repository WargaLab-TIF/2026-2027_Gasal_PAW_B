
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

if ($_SESSION['level'] != 1) {
    header("Location: ../index.php");
    exit;
}

require_once '../koneksi.php';

$id = $_GET['id'] ?? '';

$query = mysqli_prepare($conn, "SELECT * FROM pelanggan WHERE id = ?");
mysqli_stmt_bind_param($query, "s", $id);
mysqli_stmt_execute($query);

$hasil = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($hasil);

if (!$data) {
    die("Data pelanggan tidak ditemukan.");
}

if (isset($_POST['simpan'])) {
    $nama = trim($_POST['nama']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp = trim($_POST['telp']);
    $alamat = trim($_POST['alamat']);

    $update = mysqli_prepare($conn, "UPDATE pelanggan SET nama = ?, jenis_kelamin = ?, telp = ?, alamat = ? WHERE id = ?");
    mysqli_stmt_bind_param($update, "sssss", $nama, $jenis_kelamin, $telp, $alamat, $id);

    if (mysqli_stmt_execute($update)) {
        header("Location: data.php");
        exit;
    } else {
        $pesan = "Data pelanggan gagal diperbarui.";
    }
}

include '../navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Pelanggan</h4>
        </div>

        <div class="card-body">

            <?php if (isset($pesan)) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($pesan); ?>
                </div>
            <?php } ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Nama Pelanggan</label>
                    <input type="text" name="nama" class="form-control"
                        value="<?= htmlspecialchars($data['nama']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="L" <?= $data['jenis_kelamin'] == 'L' ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="P" <?= $data['jenis_kelamin'] == 'P' ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="telp" class="form-control"
                        value="<?= htmlspecialchars($data['telp'] ?? ''); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="3"><?= htmlspecialchars($data['alamat'] ?? ''); ?></textarea>
                </div>

                <button type="submit" name="simpan" class="btn btn-success">
                    Simpan Perubahan
                </button>

                <a href="data.php" class="btn btn-secondary">Kembali</a>

            </form>
        </div>
    </div>
</div>

</body>
</html>
