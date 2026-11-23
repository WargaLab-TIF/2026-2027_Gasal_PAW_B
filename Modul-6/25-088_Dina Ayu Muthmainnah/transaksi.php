<?php
include 'koneksi.php';

$query = mysqli_query($conn, "
    SELECT transaksi.*, pelanggan.nama
    FROM transaksi
    JOIN pelanggan ON transaksi.pelanggan_id = pelanggan.id
    ORDER BY transaksi.id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>
</head>
<body>

<h2>Data Transaksi</h2>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Tanggal</th>
    <th>Pelanggan</th>
    <th>Keterangan</th>
    <th>Total</th>
    <th>Aksi</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($query)) { ?>
<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['waktu_transaksi']; ?></td>
    <td><?php echo $row['nama']; ?></td>
    <td><?php echo $row['keterangan']; ?></td>
    <td><?php echo $row['total']; ?></td>
    <td>
        <a href="transaksi.php?id=<?php echo $row['id']; ?>">
            Detail
        </a>
    </td>
</tr>
<?php } ?>

</table>

<?php
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $detail = mysqli_query($conn, "
        SELECT transaksi_detail.*, barang.nama_barang
        FROM transaksi_detail
        JOIN barang ON transaksi_detail.barang_id = barang.id
        WHERE transaksi_detail.transaksi_id = $id
    ");
?>

<h2>Detail Transaksi Nomor <?php echo $id; ?></h2>

<a href="tambah_detail.php?id=<?php echo $id; ?>">
    Tambah Barang
</a>

<br><br>

<table border="1" cellpadding="10">
<tr>
    <th>Nama Barang</th>
    <th>Harga</th>
    <th>Qty</th>
    <th>Subtotal</th>
</tr>

<?php while ($d = mysqli_fetch_assoc($detail)) { ?>
<tr>
    <td><?php echo $d['nama_barang']; ?></td>
    <td><?php echo $d['harga']; ?></td>
    <td><?php echo $d['qty']; ?></td>
    <td><?php echo $d['harga'] * $d['qty']; ?></td>
</tr>
<?php } ?>

</table>

<?php } ?>

<br>
<a href="barang.php">Kelola Barang</a>

</body>
</html>