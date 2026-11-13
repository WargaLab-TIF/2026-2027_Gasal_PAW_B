<?php
require "koneksi.php";

if (empty($_GET['transaksi_id'])) {
    $id_transaksi_aktif = 1;
} else {
    $id_transaksi_aktif = $_GET['transaksi_id'];
}

if (isset($_POST['tambah_detail'])) {
    $t_id = $_POST['transaksi_id'];
    $barang_id = $_POST['barang_id'];
    $qty = $_POST['qty'];

    $q_barang = mysqli_query($conn, "SELECT harga FROM barang WHERE id = $barang_id");
    $data_b = mysqli_fetch_assoc($q_barang);
    $harga = $data_b['harga'];

    $insert = mysqli_query($conn, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES ($t_id, $barang_id, $harga, $qty)");

    if ($insert) {
        $q_sum = mysqli_query($conn, "SELECT SUM(harga * qty) AS total_sub FROM transaksi_detail WHERE transaksi_id = $t_id");
        $res_sum = mysqli_fetch_assoc($q_sum);
        $total_baru = $res_sum['total_sub'];
        if ($total_baru == "") {
            $total_baru = 0;
        }

        mysqli_query($conn, "UPDATE transaksi SET total = $total_baru WHERE id = $t_id");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>

    <p>
        <a href="dashboard.php">Data Transaksi</a> | 
        <a href="hapus.php">Kelola Barang</a>
    </p>
    <hr>

    <h2>Data Transaksi</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID Transaksi</th>
            <th>Waktu Transaksi</th>
            <th>Pelanggan ID</th>
            <th>Total</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
        <?php
        $res_transaksi = mysqli_query($conn, "SELECT * FROM transaksi");
        while ($t = mysqli_fetch_assoc($res_transaksi)) {
            $bg = "";
            if ($t['id'] == $id_transaksi_aktif) {
                $bg = "bgcolor='#FFFFCC'";
            }
            echo "<tr $bg>";
            echo "<td>" . $t['id'] . "</td>";
            echo "<td>" . $t['waktu_transaksi'] . "</td>";
            echo "<td>" . $t['pelanggan_id'] . "</td>";
            echo "<td>" . $t['total'] . "</td>";
            echo "<td>" . $t['keterangan'] . "</td>";
            echo "<td><a href='dashboard.php?transaksi_id=" . $t['id'] . "'>Pilih Detail</a></td>";
            echo "</tr>";
        }
        ?>
    </table>

    <br>

    <h2>Detail Transaksi ID: <?php echo $id_transaksi_aktif; ?></h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Harga Satuan</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
        <?php
        $q_detail = mysqli_query($conn, "SELECT td.*, b.nama_barang, b.kode_barang FROM transaksi_detail td JOIN barang b ON td.barang_id = b.id WHERE td.transaksi_id = $id_transaksi_aktif");
        while ($d = mysqli_fetch_assoc($q_detail)) {
            $subtotal = $d['harga'] * $d['qty'];
            echo "<tr>";
            echo "<td>" . $d['kode_barang'] . "</td>";
            echo "<td>" . $d['nama_barang'] . "</td>";
            echo "<td>" . $d['harga'] . "</td>";
            echo "<td>" . $d['qty'] . "</td>";
            echo "<td>" . $subtotal . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <br>

    <h3>Tambah Item Detail Transaksi</h3>
    <form method="POST" action="">
        <input type="hidden" name="transaksi_id" value="<?php echo $id_transaksi_aktif; ?>">
        <label>Pilih Barang:</label>
        <select name="barang_id" required>
            <option value="">-- Pilih Barang --</option>
            <?php
            $q_barang_opt = mysqli_query($conn, "SELECT * FROM barang WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id = $id_transaksi_aktif)");
            while ($b = mysqli_fetch_assoc($q_barang_opt)) {
                echo "<option value='" . $b['id'] . "'>" . $b['nama_barang'] . " (Stok: " . $b['stok'] . ")</option>";
            }
            ?>
        </select>
        <br><br>
        <label>Qty:</label>
        <input type="number" name="qty" value="1" min="1" required>
        <br><br>
        <button type="submit" name="tambah_detail">Simpan Detail</button>
    </form>

</body>
</html>