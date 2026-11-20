<?php
require 'koneksi.php';

$query = "SELECT barang.*, supplier.nama AS nama_supplier
          FROM barang
          JOIN supplier ON barang.supplier_id = supplier.id
          ORDER BY barang.id ASC";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>

    <style>
        body {
            font-family: Arial;
            margin: 30px;
        }

        h2 {
            color: #5b9aaa;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #d9edf7;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .tambah {
            background: #5cb85c;
            color: white;
            padding: 8px 12px;
            text-decoration: none;
        }

        .edit {
            background: #e87516;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
        }

        .hapus {
            background: #c9302c;
            color: white;
            padding: 6px 10px;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <h2>Data Master Barang</h2>

    <?php
    if (isset($_GET['pesan']) && $_GET['pesan'] == 'gagal') {
        echo "Barang tidak dapat dihapus karena sudah digunakan dalam transaksi!";
    } elseif (isset($_GET['pesan']) && $_GET['pesan'] == 'berhasil') {
        echo "Data barang berhasil dihapus!";
    }
    ?>

    <br><br>

    <a href="tambah_barang.php" class="tambah">Tambah Data Barang</a>

    <br><br>

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

        <?php while ($data = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $data['id']; ?></td>
            <td><?php echo $data['kode_barang']; ?></td>
            <td><?php echo $data['nama_barang']; ?></td>
            <td><?php echo $data['harga']; ?></td>
            <td><?php echo $data['stok']; ?></td>
            <td><?php echo $data['nama_supplier']; ?></td>
            <td>
                <a href="edit_barang.php?id=<?php echo $data['id']; ?>" class="edit">Edit</a>

                <a href="hapus_barang.php?id=<?php echo $data['id']; ?>" class="hapus"
                   onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br>

    <a href="transaksi.php">Kembali ke Data Transaksi</a>

</body>
</html>