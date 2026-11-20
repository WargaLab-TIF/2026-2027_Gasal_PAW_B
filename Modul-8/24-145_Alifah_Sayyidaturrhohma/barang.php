<?php
require_once "middleware.php";
cekOwner();

include "koneksi.php";

$query = mysqli_query($conn, "SELECT * FROM barang ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Data Barang</h2>
    <div>
        <a href="index.php">&laquo; Kembali ke Dashboard</a> |
        <a href="transaksi.php">Lihat Data Transaksi</a>
    </div>
    <br>
    <div>
        <a href="tambahBarang.php"><strong>+ Tambah Barang Baru</strong></a>
    </div>
    <br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>ID Barang</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Tindakan</th>
        </tr>

        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['id']; ?></td>
            <td><?php echo htmlspecialchars($data['kode_barang']); ?></td>
            <td><?php echo htmlspecialchars($data['nama_barang']); ?></td>
            <td><?php echo $data['harga']; ?></td>
            <td><?php echo $data['stok']; ?></td>
            <td>
                <a href="editBarang.php?id=<?php echo $data['id']; ?>">Edit</a> |
                <a href="hapusBarang.php?id=<?php echo $data['id']; ?>" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>

