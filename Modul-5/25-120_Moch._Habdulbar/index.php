<?php
include "koneksi.php";

$sql    = "SELECT id, nama, telp, alamat FROM supplier";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row" style="margin-top:20px;">
        <div class="col-xs-9"><h3 class="text-primary">Data Master Supplier</h3></div>
        <div class="col-xs-3 text-right">
            <a href="tambah.php" class="btn btn-success btn-sm">Tambah Data</a>
        </div>
    </div>
    <hr>
    <table class="table table-bordered">
        <tr class="info">
            <th>No</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Tindakan</th>
        </tr>
        <?php
        if (mysqli_num_rows($result) > 0) {
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row["nama"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["telp"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["alamat"]) . "</td>";
                echo "<td>";
                echo "<a href='edit.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                echo "<a href='hapus.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm' ";
                echo "onclick=\"return confirm('Anda yakin akan menghapus supplier ini?')\">Hapus</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>0 results</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
<?php mysqli_close($conn); ?>
