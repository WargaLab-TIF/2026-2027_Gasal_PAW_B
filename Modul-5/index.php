
<?php
require 'koneksi.php';

$dbname = "Modul 5";

// Mengecek database
$cekDatabase = mysqli_query($conn, "SHOW DATABASES LIKE '$dbname'");

if (mysqli_num_rows($cekDatabase) == 0) {
    $buatDatabase = "CREATE DATABASE `$dbname`";
    mysqli_query($conn, $buatDatabase);
}

// Memilih database
mysqli_select_db($conn, $dbname);

// Mengecek tabel
$cekTabel = mysqli_query($conn, "SHOW TABLES LIKE 'dataMaster'");

if (mysqli_num_rows($cekTabel) == 0) {

    $query = "CREATE TABLE dataMaster (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        Nama VARCHAR(255) NOT NULL,
        Telp VARCHAR(12) NOT NULL,
        Alamat VARCHAR(50)
    )";

    mysqli_query($conn, $query);
}

// Mengambil data
$query = "SELECT * FROM dataMaster";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: #333;
        }

        h2 {
            color: #5790a5;
            font-size: 24px;
            font-weight: normal;
            border-bottom: 1px solid #ddd;
            padding-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #d9edf7;
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .btn {
            display: inline-block;
            padding: 9px 13px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-size: 13px;
        }

        .tambah {
            background-color: #70ad47;
        }

        .edit {
            background-color: #e87500;
        }

        .hapus {
            background-color: #c82333;
        }
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
            <td><?php echo $no++; ?></td>
            <td><?php echo htmlspecialchars($row['Nama']); ?></td>
            <td><?php echo htmlspecialchars($row['Telp']); ?></td>
            <td><?php echo htmlspecialchars($row['Alamat']); ?></td>

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
        ?>

    </table>

</body>
</html>
