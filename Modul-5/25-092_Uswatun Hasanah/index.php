<?php
include 'koneksi.php';

$query_db = "CREATE DATABASE IF NOT EXISTS modul5";
mysqli_query($conn, $query_db);

mysqli_select_db($conn, "modul5");

$query_tbl = "CREATE TABLE IF NOT EXISTS supplier (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    telp VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL
)";
mysqli_query($conn, $query_tbl);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>
   <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #333;
        }

        h2 {
            color: #5790a5;
            font-size: 24px;
            font-weight: normal;
            border-bottom: 1px solid #ddd;
            padding-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #d9edf7;
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            padding: 9px 13px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-size: 13px;
        }

        .tambah {
            background-color: #70ad47;
        }

        .edit {
            background-color: #e87500;
        }

        .hapus {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <h2>Data Master Supplier</h2>
    <a href="tambah.php" class="btn tambah">Tambah Data</a>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Telp</th>
                <th>Alamat</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($conn, "SELECT * FROM supplier");
            while ($row = mysqli_fetch_assoc($data)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['telp']; ?></td>
                <td><?= $row['alamat']; ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn edit">Edit</a>
                    <a href="hapus.php?id=<?= $row['id']; ?>" class="btn hapus" onclick="return confirm('Anda yakin akan menghapus supplier ini?');">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>