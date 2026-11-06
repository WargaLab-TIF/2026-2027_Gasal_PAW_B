<?php
include "koneksi.php";

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

    <a href="soal-2.php" class="btn btn-success">
        Tambah Data
    </a>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php while ($data = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $data['id']; ?></td>
            <td><?php echo htmlspecialchars($data['nama']); ?></td>
            <td><?php echo htmlspecialchars($data['telp']); ?></td>
            <td><?php echo htmlspecialchars($data['alamat']); ?></td>
            <td>
                <a href="soal-3.php?id=<?php echo $data['id']; ?>"
                   class="btn btn-warning">Edit</a>

                <form action="soal-4.php" method="POST"
                      style="display:inline;"
                      onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                    <input type="hidden" name="id"
                           value="<?php echo $data['id']; ?>">
                    <button type="submit" class="btn btn-danger">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
        <?php } ?>

    </table>
</div>

</body>
</html>