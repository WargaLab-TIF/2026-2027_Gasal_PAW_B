<?php
include "validasi.php";
include "koneksi.php";
wajib_login();

$query = mysqli_query($koneksi, "
    SELECT
        transaksi.id_transaksi,
        transaksi.tanggal,
        user.nama AS nama_user,
        pelanggan.nama_pelanggan,
        transaksi.total
    FROM transaksi
    LEFT JOIN user
        ON transaksi.id_user = user.id_user
    LEFT JOIN pelanggan
        ON transaksi.id_pelanggan = pelanggan.id_pelanggan
    ORDER BY transaksi.tanggal DESC
");

if (!$query) {
    die("Query laporan gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Laporan Penjualan</h2>

<a href="index.php">Home</a>

<table>
<tr>
    <th>ID Transaksi</th>
    <th>Tanggal</th>
    <th>Kasir</th>
    <th>Pelanggan</th>
    <th>Total</th>
</tr>

<?php while ($t = mysqli_fetch_assoc($query)) { ?>
<tr>
    <td><?= $t['id_transaksi']; ?></td>
    <td><?= $t['tanggal']; ?></td>
    <td><?= htmlspecialchars($t['nama_user'] ?? '-'); ?></td>
    <td><?= htmlspecialchars($t['nama_pelanggan'] ?? '-'); ?></td>
    <td><?= rupiah($t['total']); ?></td>
</tr>
<?php } ?>

</table>

</body>
</html>
