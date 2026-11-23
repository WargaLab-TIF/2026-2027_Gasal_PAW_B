<?php
include 'koneksi.php';

$pesan = "";

if (isset($_GET['hasil'])) {
    if ($_GET['hasil'] == "gagal") {
        $pesan = "Barang TIDAK bisa dihapus karena masih digunakan pada transaksi.";
    } else {
        $pesan = "Barang berhasil dihapus.";
    }
}

if (isset($_POST['hapus'])) {
    $id = (int) $_POST['id'];

    $cek = mysqli_query($conn, "SELECT * FROM transaksi_detail WHERE barang_id = $id");

    if (mysqli_num_rows($cek) > 0) {
        header("Location: barang.php?hasil=gagal");
    } else {
        mysqli_query($conn, "DELETE FROM barang WHERE id = $id");
        header("Location: barang.php?hasil=sukses");
    }
    exit;
}

$data_barang = mysqli_query($conn, "SELECT barang.*, supplier.nama AS nama_supplier
                                       FROM barang
                                       INNER JOIN supplier ON barang.supplier_id = supplier.id");
?>
<html>
<head>
    <title>Data Barang</title>
</head>
<body>

<a href="index.php">Transaksi</a> | <a href="barang.php">Barang</a>
<hr>

<?php if ($pesan != "") { ?>
    <p><b><?php echo $pesan; ?></b></p>
<?php } ?>

<h2>Daftar Barang</h2>
<table border="1" cellpadding="6">
    <tr>
        <th style="background-color: slateblue; color: white;">ID</th>
        <th style="background-color: slateblue; color: white;">Kode</th>
        <th style="background-color: slateblue; color: white;">Nama Barang</th>
        <th style="background-color: slateblue; color: white;">Harga</th>
        <th style="background-color: slateblue; color: white;">Stok</th>
        <th style="background-color: slateblue; color: white;">Supplier</th>
        <th style="background-color: slateblue; color: white;">Aksi</th>
    </tr>
    <?php while ($b = mysqli_fetch_assoc($data_barang)) { ?>
    <tr>
        <td><?php echo $b['id']; ?></td>
        <td><?php echo htmlspecialchars($b['kode_barang']); ?></td>
        <td><?php echo htmlspecialchars($b['nama_barang']); ?></td>
        <td align="right">Rp <?php echo number_format($b['harga'], 0, ',', '.'); ?></td>
        <td align="right"><?php echo $b['stok']; ?></td>
        <td><?php echo htmlspecialchars($b['nama_supplier']); ?></td>
        <td>
            <form method="post" onsubmit="return confirm('Yakin hapus barang ini?');">
                <input type="hidden" name="id" value="<?php echo $b['id']; ?>">
                <input type="submit" name="hapus" value="Hapus">
            </form>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
