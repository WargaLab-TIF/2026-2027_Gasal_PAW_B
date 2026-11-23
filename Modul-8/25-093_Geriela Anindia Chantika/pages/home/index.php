
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../../auth/login.php");
    exit;
}

require_once "../../config/koneksi.php";

$jumlah_barang = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM barang")
)['total'];

$jumlah_supplier = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM supplier")
)['total'];

$jumlah_pelanggan = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM pelanggan")
)['total'];

$jumlah_transaksi = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM transaksi")
)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Sistem Penjualan</title>
    <link rel="stylesheet" href="../../assets/style.css">
</head>
<body>

<nav>
    <a href="index.php">Home</a>

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

    <a href="../transaksi/transaksi.php">Transaksi</a>
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

    <h2>Home</h2>

    <p>
        Selamat datang,
        <b><?= htmlspecialchars($_SESSION['nama']); ?></b>!
    </p>

    <p>
        Anda login sebagai
        <b><?= ucfirst($_SESSION['role']); ?></b>.
    </p>

    <h3>Ringkasan Sistem Penjualan</h3>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Jumlah</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Data Barang</td>
                <td><?= $jumlah_barang; ?></td>
            </tr>

            <tr>
                <td>Data Supplier</td>
                <td><?= $jumlah_supplier; ?></td>
            </tr>

            <tr>
                <td>Data Pelanggan</td>
                <td><?= $jumlah_pelanggan; ?></td>
            </tr>

            <tr>
                <td>Data Transaksi</td>
                <td><?= $jumlah_transaksi; ?></td>
            </tr>
        </tbody>
    </table>

</div>

</body>
</html>
