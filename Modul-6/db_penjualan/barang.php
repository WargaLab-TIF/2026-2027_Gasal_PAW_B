<?php
include 'koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>

<head>

    <head>
        <title>Data Barang</title>

<style>
    body {
        font-family: 'Segoe UI', Arial, sans-serif;
        background: #f5f4fa;
        padding: 30px;
        color: #252b40;
    }

    h1 {
        background: #172033;
        color: white;
        padding: 25px;
        border-radius: 12px;
        text-align: center;
        letter-spacing: 2px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    }

    th {
        background: #493b78;
        color: white;
        padding: 16px;
    }

    td {
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid #eeeaf5;
    }

    tr:hover {
        background: #f0edfa;
    }

    a {
        display: inline-block;
        color: white;
        background: #8064c8;
        padding: 9px 15px;
        border-radius: 7px;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        background: #6248a5;
    }

    .hapus {
        background: #d9536f;
    }

    .hapus:hover {
        background: #b93652;
    }
</style>

    </head>
</head>

<body>

    <h1>Data Barang</h1>


    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($query)) {
            ?>

            <tr>
                <td><?= $no++; ?></td>
                <td><?= $data['kode_barang']; ?></td>
                <td><?= $data['nama_barang']; ?></td>
                <td>Rp <?= number_format($data['harga']); ?></td>
                <td><?= $data['stok']; ?></td>
                <td>
                    <a class="hapus" href="hapus_barang.php?id=<?= $data['id']; ?>"
                        onclick="return confirm('Yakin ingin menghapus barang ini?')">
                        Hapus
                    </a>
                </td>
            </tr>

        <?php } ?>

    </table>

    <p><a href="index.php">Kembali</a></p>

</body>

</html>