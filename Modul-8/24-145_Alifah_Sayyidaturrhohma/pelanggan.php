<?php
require_once "middleware.php";
cekOwner();

require_once "koneksi.php";

$query = mysqli_query($conn, "SELECT * FROM pelanggan ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Master Pelanggan - Sistem Penjualan</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Data Master Pelanggan</h2>
    <div>
        <a href="index.php">&laquo; Kembali ke Dashboard</a>
    </div>
    <br>
    <div>
        <a href="tambahPelanggan.php"><strong>+ Tambah Pelanggan Baru</strong></a>
    </div>
    <br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>No</th>
            <th>ID Pelanggan</th>
            <th>Nama Pelanggan</th>
            <th>Jenis Kelamin</th>
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
            <td><?php echo htmlspecialchars($data['id']); ?></td>
            <td><?php echo htmlspecialchars($data['nama']); ?></td>
            <td><?php echo $data['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
            <td><?php echo htmlspecialchars($data['telp']); ?></td>
            <td><?php echo htmlspecialchars($data['alamat']); ?></td>
            <td>
                <a href="editPelanggan.php?id=<?php echo urlencode($data['id']); ?>">Edit</a> |
                <a href="hapusPelanggan.php?id=<?php echo urlencode($data['id']); ?>" onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>

