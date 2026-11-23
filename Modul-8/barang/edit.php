
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

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$query = mysqli_prepare($conn, "SELECT * FROM barang WHERE id = ?");
mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data barang tidak ditemukan. <a href='data.php'>Kembali</a>");
}

if (isset($_POST['simpan'])) {
    $kode = trim($_POST['kode_barang']);
    $nama = trim($_POST['nama_barang']);
    $harga = (int) $_POST['harga'];
    $stok = (int) $_POST['stok'];
    $supplier = (int) $_POST['supplier_id'];

    $query = mysqli_prepare($conn, "UPDATE barang SET kode_barang=?, nama_barang=?, harga=?, stok=?, supplier_id=? WHERE id=?");

    mysqli_stmt_bind_param($query, "ssiiii", $kode, $nama, $harga, $stok, $supplier, $id);

    if (mysqli_stmt_execute($query)) {
        header("Location: data.php");
        exit;
    } else {
        $pesan = "Data barang gagal diperbarui: " . mysqli_error($conn);
    }
}

$sups = mysqli_query($conn, "SELECT id, nama FROM supplier ORDER BY nama");

include '../navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Barang</h4>
        </div>

        <div class="card-body">

            <?php if (isset($pesan)) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($pesan) ?>
                </div>
            <?php } ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control"
                        value="<?= htmlspecialchars($data['kode_barang']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control"
                        value="<?= htmlspecialchars($data['nama_barang']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="harga" class="form-control"
                        value="<?= htmlspecialchars($data['harga']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control"
                        value="<?= htmlspecialchars($data['stok']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Supplier</label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">Pilih Supplier</option>

                        <?php while ($s = mysqli_fetch_assoc($sups)) { ?>
                            <option value="<?= $s['id'] ?>"
                                <?= ($data['supplier_id'] ?? '') == $s['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['nama']) ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" name="simpan" class="btn btn-success">Simpan Perubahan</button>
                <a href="data.php" class="btn btn-secondary">Kembali</a>

            </form>
        </div>
    </div>
</div>

</body>
</html>
