<?php
require_once "koneksi.php";

$query = mysqli_query($koneksi, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Data Barang</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $no = 1;
            while ($barang = mysqli_fetch_assoc($query)) :
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($barang['kode_barang']); ?></td>
                <td><?= htmlspecialchars($barang['nama_barang']); ?></td>
                <td>Rp <?= number_format($barang['harga'], 0, ',', '.'); ?></td>
                <td>
                    <form action="hapus_barang.php" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                        <input type="hidden" name="id" value="<?= $barang['id']; ?>">
                        <button type="submit" class="button button-danger">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <br>
    <a href="index.php" class="button">Kembali</a>
</div>

</body>
</html>