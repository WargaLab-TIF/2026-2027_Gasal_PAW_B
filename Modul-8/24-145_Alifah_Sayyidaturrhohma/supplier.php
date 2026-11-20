<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$query = mysqli_query($conn, "SELECT * FROM supplier ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master Supplier - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Data Master Supplier</h2>
    <div>
        <a href="index.php">&laquo; Kembali ke Dashboard</a>
    </div>
    <br>
    <div>
        <a href="tambahSupplier.php"><strong>+ Tambah Supplier Baru</strong></a>
    </div>
    <br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>Nama Supplier</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Tindakan</th>
        </tr>

        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $data['id']; ?></td>
            <td><?php echo htmlspecialchars($data['nama']); ?></td>
            <td><?php echo htmlspecialchars($data['telp']); ?></td>
            <td><?php echo htmlspecialchars($data['alamat']); ?></td>
            <td>
                <a href="editSupplier.php?id=<?php echo $data['id']; ?>">Edit</a> |
                <a href="hapusSupplier.php?id=<?php echo $data['id']; ?>" onclick="return confirm('Yakin ingin menghapus supplier ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>

