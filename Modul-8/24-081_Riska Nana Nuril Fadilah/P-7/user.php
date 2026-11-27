
<?php
require 'koneksi.php';
include 'midlewire.php';

$query = "SELECT * FROM user ORDER BY id_user ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Master User</title>

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

    <h2>Data Master User</h2>

    <a href="tambah_user.php" class="tambah">
        Tambah Data User
    </a>

    <br><br>

    <table>
        <tr>
            <th>ID User</th>
            <th>Username</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>HP</th>
            <th>Level</th>
            <th>Aksi</th>
        </tr>

        <?php while ($data = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo htmlspecialchars($data['id_user']); ?></td>
            <td><?php echo htmlspecialchars($data['username']); ?></td>
            <td><?php echo htmlspecialchars($data['nama']); ?></td>
            <td><?php echo htmlspecialchars($data['alamat']); ?></td>
            <td><?php echo htmlspecialchars($data['hp']); ?></td>
            <td><?php echo $data['level'] == 1 ? 'Owner' : 'Kasir'; ?></td>
            <td>
                <a href="edit_user.php?id_user=<?php echo $data['id_user']; ?>"
                   class="edit">Edit</a>

                <a href="hapus_user.php?id_user=<?php echo $data['id_user']; ?>"
                   class="hapus"
                   onclick="return confirm('Yakin ingin menghapus user ini?')">
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
