<?php
include "koneksi.php";

$pesan = "";

if (isset($_GET['hapus'])) {
    $id = (int) $_GET['hapus'];
    $cek = mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah
                                   FROM transaksi_detail
                                   WHERE barang_id = $id");
    $data = mysqli_fetch_assoc($cek);
    if ($data['jumlah'] > 0) {
        $pesan = "Barang tidak dapat dihapus karena masih digunakan pada "
               . $data['jumlah'] . " transaksi.";
    } else {
        mysqli_query($koneksi, "DELETE FROM barang WHERE id = $id");
        $pesan = "Data barang berhasil dihapus.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Data Barang</h1>
    <p><a href="index.php">Kembali ke transaksi</a></p>
    <?php
    if ($pesan != "") {
        echo "<p><b>" . $pesan . "</b></p>";
    }
    ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Supplier</th>
            <th>Aksi</th>
        </tr>
        <?php
        $result = mysqli_query($koneksi, "SELECT b.id, b.kode_barang, b.nama_barang, b.harga, b.stok, s.nama AS supplier
                                          FROM barang b
                                          LEFT JOIN supplier s ON b.supplier_id = s.id
                                          ORDER BY b.id");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['kode_barang'] . "</td>";
            echo "<td>" . $row['nama_barang'] . "</td>";
            echo "<td>" . number_format($row['harga'], 0, ',', '.') . "</td>";
            echo "<td>" . $row['stok'] . "</td>";
            echo "<td>" . $row['supplier'] . "</td>";
            echo "<td><a href='barang.php?hapus=" . $row['id'] . "'>Hapus</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>