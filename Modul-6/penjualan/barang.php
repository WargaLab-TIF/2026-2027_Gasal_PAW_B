
<?php
include 'koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang Cemilan</title>
    
<style>
    body {
        font-family: 'Arial', sans-serif;
        margin: 30px;
        padding: 20px;
        background-color: #fff5f8;
        color: #444;
        line-height: 1.6;
    }

    h2, h3 {
        color: #d63384;
        margin-bottom: 15px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(214, 51, 132, 0.10);
    }

    th, td {
        border: 1px solid #f5d5e3;
        padding: 12px;
        color: #444;
        text-align: left;
    }

    th {
        background-color: #e879a9;
        color: white;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #fff0f5;
    }

    tr:hover {
        background-color: #fce0eb;
        transition: 0.2s;
    }

    input, select {
        padding: 9px 12px;
        margin: 5px;
        border: 1px solid #edb5cd;
        border-radius: 6px;
        color: #444;
        background-color: white;
        outline: none;
        transition: 0.2s;
    }

    input:focus, select:focus {
        border-color: #e879a9;
        box-shadow: 0 0 5px rgba(232, 121, 169, 0.3);
    }

    button {
        padding: 9px 16px;
        background-color: #e879a9;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.2s;
    }

    button:hover {
        background-color: #d63384;
        transform: translateY(-1px);
    }

    a {
        color: #d63384;
        text-decoration: none;
        transition: 0.2s;
    }

    a:hover {
        color: #ad2165;
        text-decoration: underline;
    }
</style>

</head>
<body>
<a href="index.php">Kembali</a>
<h2>Data Barang Cemilan</h2>

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
    while ($b = mysqli_fetch_assoc($data)) {
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $b['kode_barang'] ?></td>
        <td><?= $b['nama_barang'] ?></td>
        <td>Rp <?= number_format($b['harga']) ?></td>
        <td><?= $b['stok'] ?></td>
        <td>
            <a href="hapus.php?barang=<?= $b['id'] ?>"
               onclick="return confirm('Yakin ingin menghapus barang?')">
                Hapus
            </a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
