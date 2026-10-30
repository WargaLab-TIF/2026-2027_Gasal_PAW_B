<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "modul5";

// Koneksi ke database
$conn = mysqli_connect($hostname, $username, $password, $dbname);

// Mengambil data supplier
$query = "SELECT * FROM supplier";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>
</head>
<body>

<h2>Data Master Supplier</h2>

<a href="tambah.php">Tambah Data</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Telp</th>
        <th>Alamat</th>
        <th>Tindakan</th>
    </tr>

    <?php
    $no = 1;

    while ($data = mysqli_fetch_assoc($result)) {
    ?>
    <tr>
        <td><?php echo $no++; ?></td>
        <td><?php echo $data['nama']; ?></td>
        <td><?php echo $data['telp']; ?></td>
        <td><?php echo $data['alamat']; ?></td>
        <td>
            <a href="edit.php?id=<?php echo $data['id']; ?>">Edit</a> |
            <a href="hapus.php?id=<?php echo $data['id']; ?>">Hapus</a>
        </td>
    </tr>
    <?php
    }
    ?>

</table>

</body>
</html>

<?php
mysqli_close($conn);
?>
