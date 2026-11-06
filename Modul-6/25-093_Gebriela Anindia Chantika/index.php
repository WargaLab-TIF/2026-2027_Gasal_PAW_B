<?php
require_once "koneksi.php";

$query = "
    SELECT
        t.id,
        t.waktu_transaksi,
        t.keterangan,
        t.total,
        p.nama AS nama_pelanggan
    FROM transaksi t
    JOIN pelanggan p ON p.id = t.pelanggan_id
    ORDER BY t.id DESC
";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <header class="page-header">
        <div>
            <p class="eyebrow">APLIKASI PENJUALAN</p>
            <h1>Data Transaksi</h1>
            <p class="subtitle">Daftar transaksi pembelian pelanggan.</p>
        </div>

        <nav class="nav">
            <a href="index.php" class="nav-link active">Transaksi</a>
            <a href="barang.php" class="nav-link">Data Barang</a>
        </nav>
    </header>

    <section class="panel">

        <div class="panel-heading">
            <div>
                <h2>Daftar Transaksi</h2>
                <p class="muted">Pilih detail untuk melihat rincian transaksi.</p>
            </div>
        </div>

        <div class="table-wrap">

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Keterangan</th>
                        <th class="text-right">Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (mysqli_num_rows($result) > 0): ?>

                    <?php while ($row = mysqli_fetch_assoc($result)): ?>

                    <tr>
                        <td>#<?= $row['id']; ?></td>

                        <td>
                            <?= htmlspecialchars($row['waktu_transaksi']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['nama_pelanggan']); ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['keterangan'] ?? '-'); ?>
                        </td>

                        <td class="text-right">
                            Rp <?= number_format($row['total'], 0, ',', '.'); ?>
                        </td>

                        <td>
                            <a class="button button-small"
                               href="detail.php?id=<?= $row['id']; ?>">
                                Detail
                            </a>
                        </td>
                    </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="6" class="empty">
                            Belum ada data transaksi.
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>
            </table>

        </div>
    </section>

</div>

</body>
</html>