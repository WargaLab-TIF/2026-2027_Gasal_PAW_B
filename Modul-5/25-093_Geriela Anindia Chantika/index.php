
<?php
include 'koneksi.php';

$query = "SELECT * FROM suplier";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Master Supplier</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        h2 { color: #4386a0; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th { background: #d9edf7; }
        .btn {
            display: inline-block;
            padding: 8px 12px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .tambah { background: #75ad45; }
        .edit { background: #e87919; }
        .hapus { background: #c82333; }
    </style>
</head>
<body>

<h2>Data Master Supplier</h2>

<a href="tambah.php" class="btn tambah">Tambah Data</a>

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
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($row['nama']); ?></td>
        <td><?= htmlspecialchars($row['tlp']); ?></td>
        <td><?= htmlspecialchars($row['alamat'] ?? ''); ?></td>
        <td>
            <a class="btn edit"
               href="update.php?id=<?= $row['id']; ?>">Edit</a>

            <a class="btn hapus"
               href="hapus.php?id=<?= $row['id']; ?>"
               onclick="return confirm('Anda yakin akan menghapus supplier ini?')">
               Hapus
            </a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>
