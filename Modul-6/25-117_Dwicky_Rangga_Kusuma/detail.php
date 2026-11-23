<?php
include "koneksi.php";

if (!isset($_GET['id'])) {
    die("Transaksi belum dipilih. <a href='index.php'>Kembali</a>");
}
$id = (int) $_GET['id'];
$pesan = "";

if (isset($_POST['simpan_detail'])) {
    $barang_id = (int) $_POST['barang_id'];
    $qty       = (int) $_POST['qty'];
    if ($barang_id == 0 || $qty < 1) {
        $pesan = "Pilih barang dan isi qty minimal 1.";
    } else {
        $cek = mysqli_query($koneksi, "SELECT barang_id FROM transaksi_detail
                                       WHERE transaksi_id = $id AND barang_id = $barang_id");
        if (mysqli_num_rows($cek) > 0) {
            $pesan = "Barang tersebut sudah ada di transaksi ini.";
        } else {
            $q_harga = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id = $barang_id");
            $data_b  = mysqli_fetch_assoc($q_harga);
            $harga   = $data_b['harga'];

            mysqli_query($koneksi, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty)
                                    VALUES ($id, $barang_id, $harga, $qty)");

            $q_total = mysqli_query($koneksi, "SELECT SUM(harga * qty) AS total
                                               FROM transaksi_detail
                                               WHERE transaksi_id = $id");
            $d_total = mysqli_fetch_assoc($q_total);
            $total   = (int) $d_total['total'];

            mysqli_query($koneksi, "UPDATE transaksi SET total = $total WHERE id = $id");
            $pesan = "Detail berhasil disimpan, total transaksi diperbarui.";
        }
    }
}
$q_master = mysqli_query($koneksi, "SELECT t.id, t.waktu_transaksi, t.keterangan, t.total, p.nama
                                    FROM transaksi t
                                    LEFT JOIN pelanggan p ON t.pelanggan_id = p.id
                                    WHERE t.id = $id");
$master = mysqli_fetch_assoc($q_master);
if (!$master) {
    die("Data transaksi tidak ditemukan. <a href='index.php'>Kembali</a>");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Master Detail Transaksi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <p><a href="index.php">Kembali ke daftar transaksi</a></p>
    <h1>Master Transaksi</h1>
    <table border="1">
        <tr><th>ID Transaksi</th><td><?php echo $master['id']; ?></td></tr>
        <tr><th>Tanggal</th><td><?php echo $master['waktu_transaksi']; ?></td></tr>
        <tr><th>Pelanggan</th><td><?php echo $master['nama']; ?></td></tr>
        <tr><th>Keterangan</th><td><?php echo $master['keterangan']; ?></td></tr>
        <tr><th>Total</th><td><?php echo number_format($master['total'], 0, ',', '.'); ?></td></tr>
    </table>
    <h2>Detail Transaksi</h2>
    <?php
    if ($pesan != "") {
        echo "<p><b>" . $pesan . "</b></p>";
    }
    ?>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Barang</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
        <?php
        $q_detail = mysqli_query($koneksi, "SELECT b.kode_barang, b.nama_barang, d.harga, d.qty
                                            FROM transaksi_detail d
                                            INNER JOIN barang b ON d.barang_id = b.id
                                            WHERE d.transaksi_id = $id");
        $no = 1;
        while ($row = mysqli_fetch_assoc($q_detail)) {
            $subtotal = $row['harga'] * $row['qty'];
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . $row['kode_barang'] . "</td>";
            echo "<td>" . $row['nama_barang'] . "</td>";
            echo "<td>" . number_format($row['harga'], 0, ',', '.') . "</td>";
            echo "<td>" . $row['qty'] . "</td>";
            echo "<td>" . number_format($subtotal, 0, ',', '.') . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <h3>Tambah Barang ke Transaksi</h3>
    <form method="post" action="detail.php?id=<?php echo $id; ?>">
        <table>
            <tr>
                <td>Barang</td>
                <td>
                    <select name="barang_id" required>
                        <option value="">-- Pilih Barang --</option>
                        <?php
                        $q_barang = mysqli_query($koneksi, "SELECT id, kode_barang, nama_barang, harga
                                                            FROM barang
                                                            WHERE id NOT IN (
                                                                SELECT barang_id FROM transaksi_detail
                                                                WHERE transaksi_id = $id
                                                            )");
                        while ($b = mysqli_fetch_assoc($q_barang)) {
                            echo "<option value='" . $b['id'] . "'>"
                                . $b['kode_barang'] . " - " . $b['nama_barang']
                                . " (Rp " . number_format($b['harga'], 0, ',', '.') . ")"
                                . "</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Qty</td>
                <td><input type="number" name="qty" min="1" value="1" required></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="simpan_detail" value="Simpan Detail"></td>
            </tr>
        </table>
    </form>
</body>
</html>