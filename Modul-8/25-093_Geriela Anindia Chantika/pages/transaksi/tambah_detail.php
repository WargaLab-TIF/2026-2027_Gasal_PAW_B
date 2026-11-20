
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once "../../config/koneksi.php";

$transaksi_id = isset($_GET['id'])
    ? (int) $_GET['id']
    : (int) ($_POST['transaksi_id'] ?? 0);

if ($transaksi_id < 1) {
    die("ID transaksi tidak valid.");
}

$stmt = mysqli_prepare($koneksi, "
    SELECT id FROM transaksi WHERE id = ?
");

mysqli_stmt_bind_param($stmt, "i", $transaksi_id);
mysqli_stmt_execute($stmt);

$cekTransaksi = mysqli_stmt_get_result($stmt);

if (!mysqli_fetch_assoc($cekTransaksi)) {
    die("Transaksi tidak ditemukan.");
}

$error = "";

if (isset($_POST['simpan'])) {
    $barang_id = (int) $_POST['barang_id'];
    $qty = (int) $_POST['qty'];

    if ($barang_id < 1 || $qty < 1) {
        $error = "Barang dan jumlah pembelian harus valid.";
    } else {
        mysqli_begin_transaction($koneksi);

        try {
            $stmt = mysqli_prepare($koneksi, "
                SELECT harga, stok
                FROM barang
                WHERE id = ?
                FOR UPDATE
            ");

            mysqli_stmt_bind_param($stmt, "i", $barang_id);
            mysqli_stmt_execute($stmt);

            $data_barang = mysqli_fetch_assoc(
                mysqli_stmt_get_result($stmt)
            );

            if (!$data_barang) {
                throw new Exception("Barang tidak ditemukan.");
            }

            if ($data_barang['stok'] < $qty) {
                throw new Exception("Stok barang tidak mencukupi.");
            }

            $stmt = mysqli_prepare($koneksi, "
                SELECT barang_id
                FROM transaksi_detail
                WHERE transaksi_id = ? AND barang_id = ?
            ");

            mysqli_stmt_bind_param(
                $stmt,
                "ii",
                $transaksi_id,
                $barang_id
            );

            mysqli_stmt_execute($stmt);

            if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
                throw new Exception("Barang sudah ada dalam transaksi ini.");
            }

            $harga = $data_barang['harga'];

            $stmt = mysqli_prepare($koneksi, "
                INSERT INTO transaksi_detail
                (transaksi_id, barang_id, harga, qty)
                VALUES (?, ?, ?, ?)
            ");

            mysqli_stmt_bind_param(
                $stmt,
                "iiii",
                $transaksi_id,
                $barang_id,
                $harga,
                $qty
            );

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Gagal menyimpan detail transaksi.");
            }

            $stmt = mysqli_prepare($koneksi, "
                UPDATE barang
                SET stok = stok - ?
                WHERE id = ?
            ");

            mysqli_stmt_bind_param($stmt, "ii", $qty, $barang_id);

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Gagal memperbarui stok barang.");
            }

            $stmt = mysqli_prepare($koneksi, "
                UPDATE transaksi
                SET total = (
                    SELECT COALESCE(SUM(harga * qty), 0)
                    FROM transaksi_detail
                    WHERE transaksi_id = ?
                )
                WHERE id = ?
            ");

            mysqli_stmt_bind_param(
                $stmt,
                "ii",
                $transaksi_id,
                $transaksi_id
            );

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception("Gagal memperbarui total transaksi.");
            }

            mysqli_commit($koneksi);

            header("Location: detail_transaksi.php?id=" . $transaksi_id);
            exit;

        } catch (Exception $e) {
            mysqli_rollback($koneksi);
            $error = $e->getMessage();
        }
    }
}

$query = "
    SELECT
        b.id,
        b.kode_barang,
        b.nama_barang,
        b.harga,
        b.stok
    FROM barang b
    WHERE b.id NOT IN (
        SELECT barang_id
        FROM transaksi_detail
        WHERE transaksi_id = ?
    )
    AND b.stok > 0
    ORDER BY b.nama_barang
";

$stmt = mysqli_prepare($koneksi, $query);

mysqli_stmt_bind_param($stmt, "i", $transaksi_id);
mysqli_stmt_execute($stmt);

$barang = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Detail Transaksi</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<nav>
    <a href="../home/index.php">Home</a>

    <?php if ($_SESSION['role'] == 'owner') { ?>
    <div>
        <a href="#">Data Master</a>
        <div>
            <a href="../barang/barang.php">Barang</a>
            <a href="../supplier/suplier.php">Supplier</a>
            <a href="../pelanggan/pelanggan.php">Pelanggan</a>
            <a href="../user/user.php">User</a>
        </div>
    </div>
    <?php } ?>

    <a href="transaksi.php">Transaksi</a>
    <a href="../laporan/laporan.php">Laporan</a>
    <div class="user-dropdown">
    <button class="user-button" type="button">
        <?= htmlspecialchars($_SESSION['nama']); ?>
        <span>▼</span>
    </button>

    <div class="user-dropdown-content">
        <a href="../../auth/logout.php">Logout</a>
    </div>
    </div>
</nav>

<div class="container">

    <h2>Tambah Detail Transaksi</h2>

    <p>Transaksi #<?= $transaksi_id; ?></p>

    <?php if ($error != "") { ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php } ?>

    <?php if (mysqli_num_rows($barang) > 0) { ?>

    <form method="POST" action="">
        <input
            type="hidden"
            name="transaksi_id"
            value="<?= $transaksi_id; ?>"
        >

        <label>Barang</label>

        <select name="barang_id" required>
            <option value="">-- Pilih Barang --</option>

            <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
                <option value="<?= $b['id']; ?>">
                    <?= htmlspecialchars($b['kode_barang']); ?>
                    -
                    <?= htmlspecialchars($b['nama_barang']); ?>
                    - Rp <?= number_format($b['harga'], 0, ',', '.'); ?>
                    (Stok: <?= $b['stok']; ?>)
                </option>
            <?php } ?>
        </select>

        <label>Qty</label>

        <input
            type="number"
            name="qty"
            min="1"
            step="1"
            required
            placeholder="Masukkan jumlah barang"
        >

        <button type="submit" name="simpan">
            Simpan Detail
        </button>

        <a href="detail_transaksi.php?id=<?= $transaksi_id; ?>"
           class="btn-kembali">
            Batal
        </a>
    </form>

    <?php } else { ?>

        <div class="alert">
            Tidak ada barang yang dapat ditambahkan.
            Stok mungkin habis atau semua barang sudah dimasukkan.
        </div>

        <a href="detail_transaksi.php?id=<?= $transaksi_id; ?>"
           class="btn-kembali">
            Kembali
        </a>

    <?php } ?>

</div>

</body>
</html>
