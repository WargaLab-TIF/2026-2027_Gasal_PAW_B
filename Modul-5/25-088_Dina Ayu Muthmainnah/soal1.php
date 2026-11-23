<?php 
include 'koneksi.php';

$query = "SELECT * FROM supplier";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Master Supplier</title>
</head>
<body>

<h2>Data Master Supplier</h2>

<a href="soal2.php">Tambah Data</a>

<table border="1" cellpadding="10">
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
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . $row['nama'] . "</td>";
        echo "<td>" . $row['telp'] . "</td>";
        echo "<td>" . $row['alamat'] . "</td>";
        echo "<td>";
        echo "<a href='soal3.php?id=" . $row['id'] . "'>Edit</a> | ";
        echo "<a href='soal4.php?id=" . $row['id'] . "' onclick=\"return confirm('Anda yakin akan menghapus Supplier ini?')\">Hapus</a>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>