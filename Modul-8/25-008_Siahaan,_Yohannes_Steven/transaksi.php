<?php
require "koneksi.php";
include "midlewire.php";
require "fungsi.php";

if (isset($_POST['tambah_transaksi'])) {
    $waktu_transaksi = $_POST['waktu_transaksi'];
    $pelanggan_id = $_POST['pelanggan_id'];
    $keterangan = htmlspecialchars($_POST['keterangan']);

    mysqli_query($connect, "INSERT INTO transaksi (waktu_transaksi, keterangan, total, pelanggan_id) VALUES ('$waktu_transaksi', '$keterangan', 0, '$pelanggan_id')");
    $new_id = mysqli_insert_id($connect);
    header("Location: transaksi.php?transaksi_id=" . $new_id);
    exit();
}

if (empty($_GET['transaksi_id'])) {
    $q_first = mysqli_query($connect, "SELECT id FROM transaksi ORDER BY id ASC LIMIT 1");
    $r_first = mysqli_fetch_assoc($q_first);
    $id_transaksi_aktif = $r_first ? $r_first['id'] : 0;
} else {
    $id_transaksi_aktif = $_GET['transaksi_id'];
}

if (isset($_POST['tambah_detail']) && $_POST['transaksi_id'] > 0) {
    $t_id = $_POST['transaksi_id'];
    $barang_id = $_POST['barang_id'];
    $qty = $_POST['qty'];

    $q_barang = mysqli_query($connect, "SELECT harga FROM barang WHERE id = $barang_id");
    $data_b = mysqli_fetch_assoc($q_barang);
    $harga = $data_b['harga'];

    $insert = mysqli_query($connect, "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) VALUES ($t_id, $barang_id, $harga, $qty)");

    if ($insert) {
        $q_sum = mysqli_query($connect, "SELECT SUM(harga * qty) AS total_sub FROM transaksi_detail WHERE transaksi_id = $t_id");
        $res_sum = mysqli_fetch_assoc($q_sum);
        $total_baru = $res_sum['total_sub'];
        if ($total_baru == "") {
            $total_baru = 0;
        }

        mysqli_query($connect, "UPDATE transaksi SET total = $total_baru WHERE id = $t_id");
    }
    header("Location: transaksi.php?transaksi_id=" . $t_id);
    exit();
}

if (isset($_GET['hapus_detail'])) {
    $t_id = $_GET['transaksi_id'];
    $b_id = $_GET['hapus_detail'];

    mysqli_query($connect, "DELETE FROM transaksi_detail WHERE transaksi_id = $t_id AND barang_id = $b_id");

    $q_sum = mysqli_query($connect, "SELECT SUM(harga * qty) AS total_sub FROM transaksi_detail WHERE transaksi_id = $t_id");
    $res_sum = mysqli_fetch_assoc($q_sum);
    $total_baru = $res_sum['total_sub'];
    if ($total_baru == "") {
        $total_baru = 0;
    }

    mysqli_query($connect, "UPDATE transaksi SET total = $total_baru WHERE id = $t_id");
    header("Location: transaksi.php?transaksi_id=" . $t_id);
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Penjualan</title>
</head>
<body>
    <?php include "components/navbar.php"; ?>

    <h3>Buat Transaksi Baru</h3>
    <form method="POST" action="">
        <label>Tanggal:</label>
        <input type="date" name="waktu_transaksi" required>
        <label>Pelanggan:</label>
        <select name="pelanggan_id" required>
            <option value="">-- Pilih Pelanggan --</option>
            <?php
            $q_pel = mysqli_query($connect, "SELECT * FROM pelanggan");
            while ($p = mysqli_fetch_assoc($q_pel)) {
                echo "<option value='" . $p['id'] . "'>" . $p['id'] . " - " . htmlspecialchars($p['nama']) . "</option>";
            }
            ?>
        </select>
        <label>Keterangan:</label>
        <input type="text" name="keterangan" required>
        <button type="submit" name="tambah_transaksi">Tambah Transaksi</button>
    </form>

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
        $res_transaksi = mysqli_query($connect, "SELECT * FROM transaksi");
        while ($t = mysqli_fetch_assoc($res_transaksi)) {
            $bg = "";
            if ($t['id'] == $id_transaksi_aktif) {
                $bg = "bgcolor='#FFFFCC'";
            }
            echo "<tr $bg>";
            echo "<td>" . $t['id'] . "</td>";
            echo "<td>" . $t['waktu_transaksi'] . "</td>";
            echo "<td>" . $t['pelanggan_id'] . "</td>";
            echo "<td>Rp. " . number_format($t['total'], 0, ',', '.') . "</td>";
            echo "<td>" . htmlspecialchars($t['keterangan']) . "</td>";
            echo "<td><a href='transaksi.php?transaksi_id=" . $t['id'] . "'>Pilih Detail</a></td>";
            echo "</tr>";
        }
        ?>
    </table>

    <br>

    <?php if ($id_transaksi_aktif > 0): ?>
        <h2>Detail Transaksi ID: <?= $id_transaksi_aktif ?></h2>
        <table border="1" cellpadding="5">
            <tr>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga Satuan</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
            <?php
            $q_detail = mysqli_query($connect, "SELECT td.*, b.nama_barang, b.kode_barang FROM transaksi_detail td JOIN barang b ON td.barang_id = b.id WHERE td.transaksi_id = $id_transaksi_aktif");
            while ($d = mysqli_fetch_assoc($q_detail)) {
                $subtotal = $d['harga'] * $d['qty'];
                echo "<tr>";
                echo "<td>" . $d['kode_barang'] . "</td>";
                echo "<td>" . htmlspecialchars($d['nama_barang']) . "</td>";
                echo "<td>Rp. " . number_format($d['harga'], 0, ',', '.') . "</td>";
                echo "<td>" . $d['qty'] . "</td>";
                echo "<td>Rp. " . number_format($subtotal, 0, ',', '.') . "</td>";
                echo "<td><a href='transaksi.php?transaksi_id=" . $id_transaksi_aktif . "&hapus_detail=" . $d['barang_id'] . "'>Hapus</a></td>";
                echo "</tr>";
            }
            ?>
        </table>

        <br>

        <h3>Tambah Item Detail Transaksi</h3>
        <form method="POST" action="">
            <input type="hidden" name="transaksi_id" value="<?= $id_transaksi_aktif ?>">
            <label>Pilih Barang:</label>
            <select name="barang_id" required>
                <option value="">-- Pilih Barang --</option>
                <?php
                $q_barang_opt = mysqli_query($connect, "SELECT * FROM barang WHERE id NOT IN (SELECT barang_id FROM transaksi_detail WHERE transaksi_id = $id_transaksi_aktif)");
                while ($b = mysqli_fetch_assoc($q_barang_opt)) {
                    echo "<option value='" . $b['id'] . "'>" . htmlspecialchars($b['nama_barang']) . " (Stok: " . $b['stok'] . ")</option>";
                }
                ?>
            </select>
            <br><br>
            <label>Qty:</label>
            <input type="number" name="qty" value="1" min="1" required>
            <br><br>
            <button type="submit" name="tambah_detail">Simpan Detail</button>
        </form>
    <?php endif; ?>
</body>
</html>
