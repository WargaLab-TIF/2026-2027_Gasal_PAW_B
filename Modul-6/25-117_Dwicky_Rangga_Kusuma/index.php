<?php
include "koneksi.php";

if (isset($_POST['simpan'])) {
    $tanggal    = mysqli_real_escape_string($koneksi, $_POST['waktu_transaksi']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $pelanggan  = mysqli_real_escape_string($koneksi, $_POST['pelanggan_id']);

    $sql = "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id)
            VALUES ('$tanggal', '$keterangan', 0, '$pelanggan')";
    mysqli_query($koneksi, $sql);

    $id_baru = mysqli_insert_id($koneksi);
    header("Location: detail.php?id=" . $id_baru);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Data Transaksi</h1>
    <p><a href="barang.php">Kelola Data Barang</a></p>
    <h2>Tambah Transaksi Baru</h2>
    <form method="post" action="index.php">
        <table>
            <tr>
                <td>Tanggal</td>
                <td><input type="date" name="waktu_transaksi" required></td>
            </tr>
            <tr>
                <td>Pelanggan</td>
                <td>
                    <select name="pelanggan_id" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        <?php
                        $q_pel = mysqli_query($koneksi, "SELECT id, nama FROM pelanggan");
                        while ($p = mysqli_fetch_assoc($q_pel)) {
                            echo "<option value='" . $p['id'] . "'>" . $p['nama'] . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td><textarea name="keterangan"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="simpan" value="Simpan & Isi Detail"></td>
            </tr>
        </table>
    </form>

    <h2>Daftar Transaksi</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Keterangan</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
        <?php
        $query = "SELECT t.id, t.waktu_transaksi, t.keterangan, t.total, p.nama
                  FROM transaksi t
                  LEFT JOIN pelanggan p ON t.pelanggan_id = p.id
                  ORDER BY t.id";
        $result = mysqli_query($koneksi, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['waktu_transaksi'] . "</td>";
            echo "<td>" . $row['nama'] . "</td>";
            echo "<td>" . $row['keterangan'] . "</td>";
            echo "<td>" . number_format($row['total'], 0, ',', '.') . "</td>";
            echo "<td><a href='detail.php?id=" . $row['id'] . "'>Lihat Detail</a></td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>