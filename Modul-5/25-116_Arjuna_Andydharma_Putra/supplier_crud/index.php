<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_supplier";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        h2 { color: #333; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th { background-color: #a8d5e5; padding: 10px; text-align: left; border: 1px solid #ddd; }
        td { padding: 8px; border: 1px solid #ddd; }
        .btn-tambah {
            background-color: #28a745;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 4px;
            float: right;
        }
        .btn-edit {
            background-color: #e67e22;
            color: white;
            padding: 5px 12px;
            text-decoration: none;
            border-radius: 3px;
            margin-right: 5px;
        }
        .btn-hapus {
            background-color: #7d3c0a;
            color: white;
            padding: 5px 12px;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
</head>
<body>

<h2>Data Master Supplier</h2>
<a href="tambah.php" class="btn-tambah">Tambah Data</a>
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
    $sql = "SELECT id, nama, telp, alamat FROM supplier";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        $no = 1;
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $row["nama"] . "</td>";
            echo "<td>" . $row["telp"] . "</td>";
            echo "<td>" . $row["alamat"] . "</td>";
            echo "<td>
                    <a href='edit.php?id=" . $row["id"] . "' class='btn-edit'>Edit</a>
                    <a href='hapus.php?id=" . $row["id"] . "' class='btn-hapus' 
                       onclick=\"return confirm('Anda yakin akan menghapus supplier ini?');\">Hapus</a>
                  </td>";
            echo "</tr>";
            $no++;
        }
    } else {
        echo "<tr><td colspan='5'>0 results</td></tr>";
    }
    mysqli_close($conn);
    ?>
</table>

</body>
</html>
