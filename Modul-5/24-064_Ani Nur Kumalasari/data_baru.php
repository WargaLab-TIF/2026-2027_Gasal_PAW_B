<?php
include "koneksi.php";

$query = mysqli_query($koneksi, "SELECT * FROM master_suppiler ORDER BY id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 25px;
            color: #555;
        }

        h2 {
            color: #39758d;
            font-size: 24px;
            font-weight: normal;
            border-bottom: 1px solid #ddd;
            padding-bottom: 12px;
        }

        .tambah {
            float: right;
            background: #75ad43;
            color: white;
            padding: 9px 15px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: -65px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
        }

        th {
            background: #d9edf7;
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
            color: #555;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .edit {
            background: #ed6b16;
            color: white;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 4px;
            margin-right:8px;
        }

        .hapus {
            background: #c82333;
            color: white;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<h2>Data Master Supplier</h2>

<a href="tambah_data.php" class="tambah">Tambah Data</a>

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
    while ($row = mysqli_fetch_assoc($query)) {
    ?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo htmlspecialchars($row['Nama']); ?></td>
        <td><?php echo htmlspecialchars($row['Telp']); ?></td>
        <td><?php echo htmlspecialchars($row['Alamat']); ?></td>
        <td>
            <a class="edit"
               href="edit_data.php?id=<?php echo $row['id']; ?>">
               Edit
            </a>

            <a class="hapus"
               href="hapus_data.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Anda yakin akan menghapus supplier ini?')">
               Hapus
            </a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
