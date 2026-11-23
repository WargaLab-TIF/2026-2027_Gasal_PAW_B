<?php
include 'koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>

<h2>Data Barang</h2>

<table border="1" cellpadding="10">

<tr>
    <th>ID</th>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($query)) { ?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['kode_barang']; ?></td>
    <td><?php echo $row['nama_barang']; ?></td>
    <td><?php echo $row['harga']; ?></td>
    <td><?php echo $row['stok']; ?></td>

    <td>
        <a href="hapus_barang.php?id=<?php echo $row['id']; ?>"
        onclick="return confirm('Yakin ingin menghapus barang?')">
            Hapus
        </a>
    </td>
</tr>

<?php } ?>

</table>

<br>

<a href="transaksi.php">Kembali ke Transaksi</a>

</body>
</html>