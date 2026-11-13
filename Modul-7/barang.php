<?php
include 'koneksi.php';

$query = mysqli_query($conn, "
    SELECT barang.*, supplier.nama AS nama_supplier
    FROM barang
    JOIN supplier ON barang.supplier_id = supplier.id
    ORDER BY barang.id ASC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 30px;
        }

        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #2878c8;
            color: white;
        }

        .btn {
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .hapus {
            background: #dc3545;
        }

        .kembali {
            background: #2878c8;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Data Master Barang</h2>

    <a href="transaksi.php" class="btn kembali">
        Kembali ke Transaksi
    </a>

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

        <?php while ($row = mysqli_fetch_assoc($query)) { ?>

        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= htmlspecialchars($row['kode_barang']); ?></td>
            <td><?= htmlspecialchars($row['nama_barang']); ?></td>
            <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
            <td><?= $row['stok']; ?></td>
            <td><?= htmlspecialchars($row['nama_supplier']); ?></td>
            <td>
                <form action="hapus_barang.php" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus barang ini?')">

                    <input type="hidden" name="id"
                           value="<?= $row['id']; ?>">

                    <button type="submit" name="hapus"
                            class="btn hapus">
                        Hapus
                    </button>

                </form>
            </td>
        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>