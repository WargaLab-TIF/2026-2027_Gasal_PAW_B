
<?php
include 'koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM supplier");
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
            color: cadetblue;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: lightblue;
        }

        th, td {
            border: 1px solid lightgray;
            padding: 10px;
            text-align: left;
        }

        .tambah {
            background-color: mediumseagreen;
            color: white;
            padding: 10px;
            text-decoration: none;
            float: right;
            margin-bottom: 15px;
        }

        .edit {
            background-color: chocolate;
            color: white;
            padding: 7px;
            text-decoration: none;
        }

        .hapus {
            background-color: firebrick;
            color: white;
            padding: 7px;
            text-decoration: none;
        }
    </style>
</head>
<body>

    <div class="container">

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

            while ($data = mysqli_fetch_assoc($query)) {
                ?>

                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($data['nama']); ?></td>
                    <td><?php echo htmlspecialchars($data['telp']); ?></td>
                    <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $data['id']; ?>" class="edit">Edit</a>

                        <a href="hapus.php?id=<?php echo $data['id']; ?>"
                         class="hapus"
                         onclick="return confirm('Anda yakin ingin menghapus data ini?')">
                         Hapus
                     </a>
                 </td>
             </tr>

         <?php } ?>

     </table>

 </div>

</body>
</html>
