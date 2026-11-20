<?php
include 'koneksi.php';

$query = "SELECT * FROM supplier";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Data Master Supplier</h2>
    <hr>

    <a href="tambah.php" class="btn tambah">
        Tambah Data
    </a>

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
                <a href="edit.php?id=<?php echo $row['id']; ?>"
                   class="btn edit">Edit</a>

                <a href="hapus.php?id=<?php echo $row['id']; ?>"
                   class="btn hapus"
                   onclick="return confirm('Anda yakin akan menghapus supplier ini?')">
                    Hapus
                </a>
            </td>
        </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>