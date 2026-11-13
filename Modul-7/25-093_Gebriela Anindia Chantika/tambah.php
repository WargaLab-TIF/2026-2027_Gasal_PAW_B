<?php
require_once "koneksi.php";

$transaksi_id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

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

$query = "
    SELECT
        b.id,
        b.kode_barang,
        b.nama_barang,
        b.harga
    FROM barang b
    WHERE b.id NOT IN (
        SELECT barang_id
        FROM transaksi_detail
        WHERE transaksi_id = ?
    )
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
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container narrow">

    <header class="page-header">
        <div>
            <p class="eyebrow">TRANSAKSI #<?= $transaksi_id; ?></p>
            <h1>Tambah Detail</h1>
            <p class="subtitle">Pilih barang dan masukkan jumlah pembelian.</p>
        </div>
    </header>

    <section class="panel">

        <?php if (mysqli_num_rows($barang) > 0): ?>

        <form action="simpan_detail.php" method="POST">

            <input
                type="hidden"
                name="transaksi_id"
                value="<?= $transaksi_id; ?>"
            >

            <label for="barang_id">Barang</label>

            <select name="barang_id" id="barang_id" required>

                <option value="">-- Pilih Barang --</option>

                <?php while ($b = mysqli_fetch_assoc($barang)): ?>

                    <option value="<?= $b['id']; ?>">

                        <?= htmlspecialchars($b['kode_barang']); ?>
                        -
                        <?= htmlspecialchars($b['nama_barang']); ?>
                        -
                        Rp <?= number_format($b['harga'], 0, ',', '.'); ?>

                    </option>

                <?php endwhile; ?>

            </select>

            <label for="qty">Qty</label>

            <input
                type="number"
                name="qty"
                id="qty"
                min="1"
                step="1"
                required
                placeholder="Masukkan jumlah barang"
            >

            <div class="form-actions">

                <button class="button" type="submit">
                    Simpan Detail
                </button>

                <a href="detail.php?id=<?= $transaksi_id; ?>"
                   class="button button-light">
                    Batal
                </a>

            </div>

        </form>

        <?php else: ?>

            <div class="notice">
                Semua barang sudah dimasukkan ke transaksi ini,
                atau belum ada data barang.
            </div>

            <a href="detail.php?id=<?= $transaksi_id; ?>"
               class="button button-light">
                Kembali
            </a>

        <?php endif; ?>

    </section>

</div>

</body>
</html>