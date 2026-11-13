<?php
require "koneksi.php";

$pesan = "";
if (isset($_GET['hapus_id'])) {
    $id_barang = $_GET['hapus_id'];

    $cek_relasi = mysqli_query($conn, "SELECT * FROM transaksi_detail WHERE barang_id = $id_barang");

    if (mysqli_num_rows($cek_relasi) > 0) {
        $pesan = "Gagal dihapus! Barang tersebut masih digunakan pada data transaksi.";
    } else {
        mysqli_query($conn, "DELETE FROM barang WHERE id = $id_barang");
        $pesan = "Data barang berhasil dihapus.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola & Hapus Barang</title>
</head>
<body>

    <p>
        <a href="dashboard.php">Dashboard (Master-Detail)</a> | 
        <a href="hapus.php">Kelola / Hapus Barang</a>
    </p>
    <hr>

    <h2>Daftar Barang (Master Barang)</h2>

    <?php
    if ($pesan != "") {
        echo "<p><b><i>" . $pesan . "</i></b></p>";
    }
    ?>

    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM barang");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['kode_barang'] . "</td>";
            echo "<td>" . $row['nama_barang'] . "</td>";
            echo "<td>" . $row['harga'] . "</td>";
            echo "<td>" . $row['stok'] . "</td>";
            echo "<td><a href='hapus.php?hapus_id=" . $row['id'] . "'>Hapus</a></td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>
</html>