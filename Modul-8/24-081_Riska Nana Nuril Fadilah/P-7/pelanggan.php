<?php
require 'koneksi.php';
include 'midlewire.php';

$query = "SELECT * FROM pelanggan ORDER BY id ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pelanggan</title>

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

    <h2>Data Master Pelanggan</h2>

    <a href="tambah_pelanggan.php" class="tambah">
        Tambah Data Pelanggan
    </a>

    <br><br>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php while ($data = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $data['id']; ?></td>
            <td><?php echo $data['nama']; ?></td>
            <td><?php echo $data['jenis_kelamin']; ?></td>
            <td><?php echo $data['telp']; ?></td>
            <td><?php echo $data['alamat']; ?></td>
            <td>
                <a href="edit_pelanggan.php?id=<?php echo $data['id']; ?>"
                   class="edit">Edit</a>

                <a href="hapus_pelanggan.php?id=<?php echo $data['id']; ?>"
                   class="hapus"
                   onclick="return confirm('Yakin ingin menghapus pelanggan ini?')">
                    Hapus
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <br>

    <a href="index.php">Kembali ke Home</a>

</body>
</html>