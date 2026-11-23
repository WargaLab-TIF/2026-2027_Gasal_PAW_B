
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once "../../config/koneksi.php";

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
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<nav>
    <a href="../home/index.php">Home</a>

    <?php if ($_SESSION['role'] == 'owner') { ?>
    <div>
        <a href="#">Data Master</a>
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
    <h2>Data Transaksi</h2>

    <a href="tambah_transaksi.php" class="btn-tambah">
    + Tambah Transaksi
	</a>

	<br><br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Keterangan</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && mysqli_num_rows($result) > 0) { ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td>#<?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['waktu_transaksi']); ?></td>
                <td><?= htmlspecialchars($row['nama_pelanggan']); ?></td>
                <td><?= htmlspecialchars($row['keterangan'] ?? '-'); ?></td>
                <td>Rp <?= number_format($row['total'], 0, ',', '.'); ?></td>
                <td>
                    <a href="detail_transaksi.php?id=<?= $row['id']; ?>" class="btn-tambah" >
                        Detail
                    </a>
                </td>
            </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6">Belum ada data transaksi.</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
