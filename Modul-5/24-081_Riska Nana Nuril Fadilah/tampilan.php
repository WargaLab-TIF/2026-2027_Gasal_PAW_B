<?php
require 'koneksi.php';

$query = "SELECT id, nama, telp, alamat FROM supplier";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>

    <style>
        body {
            font-family: Arial, sans-serif;
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
            background-color: #d9edf7;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .tambah {
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            text-decoration: none;
            float: right;
            margin-bottom: 15px;
        }

        .edit {
            background-color: #e87516;
            color: white;
            padding: 7px;
            text-decoration: none;
        }

        .hapus {
            background-color: #c9302c;
            color: white;
            padding: 7px;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <h2>Data Master Supplier</h2>

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

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>

        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($row['nama']); ?></td>
            <td><?php echo htmlspecialchars($row['telp']); ?></td>
            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit">Edit</a>

                <a href="hapus.php?id=<?php echo $row['id']; ?>"
                   class="hapus"
                   onclick="return confirm('Anda yakin akan menghapus supplier ini?')">
                   Hapus
                </a>
            </td>
        </tr>

        <?php
            }
        } else {
            echo "<tr><td colspan='5'>Tidak ada data supplier</td></tr>";
        }
        ?>

    </table>

</body>
</html>