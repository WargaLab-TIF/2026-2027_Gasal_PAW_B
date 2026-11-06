<?php
require 'koneksi.php';

$hasil = mysqli_query($koneksi, "SELECT b.*,s.nama AS nama_supplier FROM barang b LEFT JOIN supplier s ON s.id=b.supplier_id ORDER BY b.id");

$pesan = $_GET['pesan'] ?? '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Data Barang</title>

    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 25px;
        }
        .box {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 24px;
            border-radius: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        th {
            background: #263b59;
            color: white;
        }
        button {
            padding: 7px 10px;
            background: #b42318;
            color: white;
            border: 0;
            border-radius: 5px;
            cursor: pointer;
        }
        .msg {
            padding: 12px;
            background: #fff2cc;
            margin: 12px 0;
        }
    </style>
</head>

<body>
    <div class="box">
        <p><a href="index.php">← Kembali ke transaksi</a></p>
        <h2>Data Barang</h2>
        <?php if($pesan==='terpakai'){ ?>
            <div class="msg">Barang tidak dapat dihapus karena masih digunakan pada transaksi.</div>
        <?php } ?>

        <?php if($pesan==='hapus'){ ?>
            <div class="msg">Data barang berhasil dihapus.</div>
        <?php } ?>

        <table>
            <tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Supplier</th>
                <th>Aksi</th>
            </tr>

            <?php while($r=mysqli_fetch_assoc($hasil)){ ?>

                <tr>
                    <td><?= (int)$r['id'] ?></td>
                    <td><?= htmlspecialchars($r['kode_barang']) ?></td>
                    <td><?= htmlspecialchars($r['nama_barang']) ?></td>
                    <td>Rp <?= number_format($r['harga'],0,',','.') ?></td>
                    <td><?= (int)$r['stok'] ?></td>
                    <td><?= htmlspecialchars($r['nama_supplier'] ?? '-') ?></td>
                    <td>
                        <form action="hapus_barang.php" method="post" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                            <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>