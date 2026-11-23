<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

require_once '../koneksi.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$cek_transaksi = mysqli_query($conn, "SELECT id FROM transaksi WHERE id = $id");

if ($id <= 0 || !$cek_transaksi || mysqli_num_rows($cek_transaksi) == 0) {
    die("Transaksi tidak ditemukan.");
}

if (isset($_POST['simpan'])) {
    $barang_id = (int) $_POST['barang_id'];
    $qty = (int) $_POST['qty'];

    if ($barang_id <= 0 || $qty <= 0) {
        $pesan = "Barang dan jumlah harus diisi dengan benar.";
    } else {
        $cek = mysqli_query($conn, "SELECT barang_id FROM transaksi_detail WHERE transaksi_id = $id AND barang_id = $barang_id");

        if (mysqli_num_rows($cek) > 0) {
            $pesan = "Barang sudah dimasukkan ke transaksi ini.";
        } else {
            $b = mysqli_query($conn, "SELECT harga FROM barang WHERE id = $barang_id");
            $barang = mysqli_fetch_assoc($b);

            if (!$barang) {
                $pesan = "Barang tidak ditemukan.";
            } else {
                $harga = (int) $barang['harga'];

                $q = mysqli_prepare($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($q, "iiii", $id, $barang_id, $harga, $qty);

                if (mysqli_stmt_execute($q)) {
                    mysqli_query($conn, "UPDATE transaksi SET total = (SELECT COALESCE(SUM(harga * qty), 0) FROM transaksi_detail WHERE transaksi_id = $id) WHERE id = $id");

                    header("Location: index.php?id=$id");
                    exit;
                } else {
                    $pesan = "Gagal menambahkan barang: " . mysqli_stmt_error($q);
                }
            }
        }
    }
}

$barang = mysqli_query($conn, "SELECT * FROM barang WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id = $id) ORDER BY nama_barang");

include '../navbar.php';
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Tambah Barang Transaksi</h4>
        </div>

        <div class="card-body">

            <?php if (isset($pesan)) { ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($pesan); ?>
                </div>
            <?php } ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Barang</label>
                    <select name="barang_id" class="form-select" required>
                        <option value="">Pilih Barang</option>

                        <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
                            <option value="<?= $b['id']; ?>">
                                <?= htmlspecialchars($b['nama_barang']); ?>
                                - Rp <?= number_format($b['harga'], 0, ',', '.'); ?>
                            </option>
                        <?php } ?>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="qty" class="form-control" min="1" required>
                </div>

                <button type="submit" name="simpan" class="btn btn-success">
                    Simpan Barang
                </button>

                <a href="index.php?id=<?= $id; ?>" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>
</div>

</body>
</html>
