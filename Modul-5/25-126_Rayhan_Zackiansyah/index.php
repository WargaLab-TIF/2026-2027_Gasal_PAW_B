<?php
include "koneksi.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        h2 { color: #337ab7; font-family: Arial, sans-serif; }
        body { font-size: 12px; }
        th { background-color: #d9edf7; }
    </style>
</head>
<body>
<div class="container">
    <div class="pull-right" style="margin-top: 25px;">
        <a href="tambah.php" class="btn btn-success btn-sm">Tambah Data</a>
    </div>

    <h2>Data Master Supplier</h2>
    <hr>

    <table class="table table-bordered">
        <thead>
            <tr class="info">
                <th>No</th>
                <th>Nama</th>
                <th>Telp</th>
                <th>Alamat</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
<?php
$sql = "SELECT id, nama, telp, alamat FROM supplier";
$res = mysqli_query($conn, $sql);
$no = 1;

if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        echo "<tr>";
        echo "<td>" . $no . "</td>";
        echo "<td>" . $row["nama"] . "</td>";
        echo "<td>" . $row["telp"] . "</td>";
        echo "<td>" . $row["alamat"] . "</td>";
        echo "<td>";
        echo "<a href='edit.php?id=" . $row["id"] . "' class='btn btn-warning btn-xs'>Edit</a> ";
        echo "<a href='hapus.php?id=" . $row["id"] . "' class='btn btn-danger btn-xs' onclick='return confirm(\"Anda yakin akan menghapus supplier ini?\")'>Hapus</a>";
        echo "</td>";
        echo "</tr>";
        $no++;
    }
}

mysqli_close($conn);
?>
        </tbody>
    </table>
</div>
</body>
</html>