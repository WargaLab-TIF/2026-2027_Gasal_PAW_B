<?php
include "koneksi.php";

$result = mysqli_query($conn, "SELECT * FROM supplier");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
        }
        h2 {
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
        }
        .pesan {
            padding: 10px;
            margin-bottom: 20px;
            background-color: #e6f4ea;
            border: 1px solid #b7dfc3;
        }
        .tambah {
            display: inline-block;
            margin-bottom: 20px;
            padding: 9px 15px;
            background-color: #333;
            color: white;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        .edit {
            margin-right: 10px;
        }
        .hapus {
            color: red;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            padding: 8px;
            width: 300px;
            margin-bottom: 15px;
        }
        button {
            padding: 8px 15px;
            cursor: pointer;
        }
        .batal {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Data Master Supplier</h2>
        <?php if (isset($_GET['pesan'])) { ?>
            <div class="pesan"><?= $_GET['pesan'] ?></div>
        <?php } ?>
        <a href="tambah.php" class="tambah">Tambah Data</a>
        <table>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Telp</th>
                <th>Alamat</th>
                <th>Tindakan</th>
            </tr>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['telp'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="edit">Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="hapus"
                       onclick="return confirm('Anda yakin akan menghapus supplier ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>