<?php
include "koneksi.php";

$sql = "SELECT * FROM suplier";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Supplier</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f1f5f9;
            color: #334155;
        }
        .container {
            width: 85%;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
        }
        h2 { color: #256da8; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #dbeafe;
            color: #1e3a5f;
        }
        a, button {
            background-color: #256da8;
            color: white;
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }
        .hapus { background-color: #64748b; }
    </style>
</head>
<body>
<div class="container">
    <h2>Data Supplier</h2>

    <a href="tambah.php">Tambah Data</a>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Telpon</th>
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
            <td><?php echo $data['telpon']; ?></td>
            <td><?php echo $data['alamat']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $data['id']; ?>">Edit</a>

                <a class="hapus"
                   href="hapus.php?id=<?php echo $data['id']; ?>"
                   onclick="return confirm('Apakah kamu yakin ingin menghapus data ini?')">
                    Hapus
                </a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>

<?php
mysqli_close($conn);
?>