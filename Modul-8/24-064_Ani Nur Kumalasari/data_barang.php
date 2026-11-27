<?php
include "validasi.php";
include "koneksi.php";
wajib_owner();

$query = mysqli_query($koneksi, "
    SELECT
        barang.*,
        barang.id_barang AS id,
        barang.id_barang AS kode_barang,
        supplier.nama_supplier AS nama_supplier
    FROM barang
    LEFT JOIN supplier ON barang.id_supplier = supplier.id_supplier
    ORDER BY barang.id_barang ASC
");

if (!$query) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Data Master Barang</h2>

<a href="index.php">Home</a> |
<a href="tambah_barang.php">+ Tambah Barang</a>

<table>
<tr>
    <th>ID</th>
    <th>Kode Barang</th>
    <th>Nama Barang</th>
    <th>Harga</th>
    <th>Stok</th>
    <th>Supplier</th>
    <th>Aksi</th>
</tr>

<?php while ($b = mysqli_fetch_assoc($query)) { ?>
<tr>
    <td><?= $b['id']; ?></td>
    <td><?= htmlspecialchars($b['kode_barang']); ?></td>
    <td><?= htmlspecialchars($b['nama_barang']); ?></td>
    <td><?= rupiah($b['harga']); ?></td>
    <td><?= $b['stok']; ?></td>
    <td><?= htmlspecialchars($b['nama_supplier'] ?? '-'); ?></td>
    <td>
        <a href="edit_barang.php?id=<?= $b['id']; ?>">Edit</a> |
        <a href="hapus_barang.php?id=<?= $b['id']; ?>"
           onclick="return confirm('Yakin ingin menghapus barang?')">
           Hapus
        </a>
    </td>
</tr>
<?php } ?>
</table>

</body>
</html>
