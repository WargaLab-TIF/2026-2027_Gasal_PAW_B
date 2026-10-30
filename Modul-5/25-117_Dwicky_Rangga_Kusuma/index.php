<?php
include "koneksi.php";

$sql = "SELECT * FROM supplier";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>
    <style>
        body {
            font-family: Arial;
            margin: 40px;
            color: #555;
        }
        h2 {
            color: #43899b;
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
        a, button {
            padding: 7px 12px;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }
        .tambah {
            background: #5cb85c;
            float: right;
        }
        .edit {
            background: #e87522;
        }
        .hapus {
            background: #c9302c;
        }
    </style>
</head>
<body>
<h2>Data Master Supplier</h2>
<a href="tambah.php" class="tambah">Tambah Data</a>
<br><br>
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
        <td><?php echo $no++; ?></td>
        <td><?php echo htmlspecialchars($row['nama']); ?></td>
        <td><?php echo htmlspecialchars($row['Telp']); ?></td>
        <td><?php echo htmlspecialchars($row['Alamat']); ?></td>
        <td>
            <a href="edit.php?id=<?php echo $row['id']; ?>"
               class="edit">Edit</a>
            <form action="hapus.php" method="POST" style="display:inline;"
                  onsubmit="return confirm('Yakin ingin menghapus supplier ini?')">
                <input type="hidden" name="id"
                       value="<?php echo $row['id']; ?>">
                <button type="submit" class="hapus">Hapus</button>
            </form>
        </td>
    </tr>

    <?php } ?>

</table>
</body>
</html>

<?php
mysqli_close($conn);
?>
