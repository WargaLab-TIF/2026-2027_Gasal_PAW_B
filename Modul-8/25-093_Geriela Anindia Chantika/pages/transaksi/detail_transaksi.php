
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once "../../config/koneksi.php";

$id = isset($_GET['id']) ? (int) $_GET['id'] : (int) ($_POST['transaksi_id'] ?? 0);

if ($id < 1) {
    die("ID transaksi tidak valid.");
}

$stmt = mysqli_prepare($koneksi, "
    SELECT transaksi.*, pelanggan.nama AS nama_pelanggan
    FROM transaksi
    JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    WHERE transaksi.id = ?
");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$transaksi = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$transaksi) {
    die("Transaksi tidak ditemukan.");
}

$pesan = "";

if (isset($_POST['hapus_detail'])) {
    $barang_id = (int) $_POST['barang_id'];

    mysqli_begin_transaction($koneksi);

    try {
        $stmt = mysqli_prepare($koneksi, "
            SELECT qty
            FROM transaksi_detail
            WHERE transaksi_id = ? AND barang_id = ?
            FOR UPDATE
        ");

        mysqli_stmt_bind_param($stmt, "ii", $id, $barang_id);
        mysqli_stmt_execute($stmt);

        $detail = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if (!$detail) {
            throw new Exception("Detail transaksi tidak ditemukan.");
        }

        $qty = (int) $detail['qty'];

        $stmt = mysqli_prepare($koneksi, "
            UPDATE barang
            SET stok = stok + ?
            WHERE id = ?
        ");

        mysqli_stmt_bind_param($stmt, "ii", $qty, $barang_id);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Gagal mengembalikan stok barang.");
        }

        $stmt = mysqli_prepare($koneksi, "
            DELETE FROM transaksi_detail
            WHERE transaksi_id = ? AND barang_id = ?
        ");

        mysqli_stmt_bind_param($stmt, "ii", $id, $barang_id);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Gagal menghapus detail transaksi.");
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

        mysqli_stmt_bind_param($stmt, "ii", $id, $id);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Gagal memperbarui total transaksi.");
        }

        mysqli_commit($koneksi);

        header("Location: detail_transaksi.php?id=" . $id . "&pesan=hapus");
        exit;

    } catch (Throwable $e) {
        mysqli_rollback($koneksi);
        $pesan = $e->getMessage();
    }
}

$stmt = mysqli_prepare($koneksi, "
    SELECT transaksi_detail.*, barang.kode_barang, barang.nama_barang
    FROM transaksi_detail
    JOIN barang ON transaksi_detail.barang_id = barang.id
    WHERE transaksi_detail.transaksi_id = ?
");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$query_detail = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<nav>
    <a href="../home/index.php">Home</a>

    <?php if ($_SESSION['role'] == 'owner') { ?>
    <div>
        <span>Data Master</span>
        <div>
            <a href="../barang/barang.php">Data Barang</a>
            <a href="../supplier/suplier.php">Data Supplier</a>
            <a href="../pelanggan/pelanggan.php">Data Pelanggan</a>
            <a href="../user/user.php">Data User</a>
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

    <h2>Detail Transaksi</h2>

    <?php if (isset($_GET['pesan']) && $_GET['pesan'] == 'hapus') { ?>
        <div class="alert">
            Detail transaksi berhasil dihapus dan stok barang dikembalikan.
        </div>
    <?php } ?>

    <?php if ($pesan != "") { ?>
        <div class="alert alert-error">
            <?= htmlspecialchars($pesan); ?>
        </div>
    <?php } ?>

    <div class="card">
        <p><strong>ID Transaksi:</strong> <?= $transaksi['id']; ?></p>
        <p><strong>Pelanggan:</strong> <?= htmlspecialchars($transaksi['nama_pelanggan']); ?></p>
        <p><strong>Waktu Transaksi:</strong> <?= htmlspecialchars($transaksi['waktu_transaksi']); ?></p>
        <p><strong>Keterangan:</strong> <?= htmlspecialchars($transaksi['keterangan'] ?? '-'); ?></p>
    </div>

    <br>

    <a href="tambah_detail.php?id=<?= $id; ?>" class="btn-tambah">
        + Tambah Barang
    </a>

    <br><br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
            $total = 0;

            if (mysqli_num_rows($query_detail) > 0) {
                while ($detail = mysqli_fetch_assoc($query_detail)) {
                    $subtotal = $detail['harga'] * $detail['qty'];
                    $total += $subtotal;
            ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($detail['kode_barang']); ?></td>
                    <td><?= htmlspecialchars($detail['nama_barang']); ?></td>
                    <td>Rp <?= number_format($detail['harga'], 0, ',', '.'); ?></td>
                    <td><?= $detail['qty']; ?></td>
                    <td>Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                    <td>
                        <form method="POST"
                              action="detail_transaksi.php?id=<?= $id; ?>"
                              onsubmit="return confirm('Yakin ingin menghapus barang ini dari transaksi?')">

                            <input type="hidden" name="transaksi_id" value="<?= $id; ?>">
                            <input type="hidden" name="barang_id" value="<?= $detail['barang_id']; ?>">

                            <button type="submit" name="hapus_detail" class="btn-hapus">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="7">Belum ada barang dalam transaksi ini.</td>
                </tr>
            <?php } ?>
        </tbody>

        <tfoot>
            <tr>
                <th colspan="5" class="text-right">TOTAL TRANSAKSI</th>
                <th>Rp <?= number_format($total, 0, ',', '.'); ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>

    <br>

    <a href="transaksi.php" class="btn-kembali">Kembali</a>

</div>

</body>
</html>
